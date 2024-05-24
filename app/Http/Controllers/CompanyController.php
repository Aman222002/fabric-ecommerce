<?php

namespace App\Http\Controllers;

use App\Services\GoCardlessServices;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobApply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Address;
use App\Models\Plan;
use App\Models\Permissionaccess;
use App\Models\UserSubscription;
use App\Http\Requests\CompanyRagistrationRequest;
use App\Jobs\CompanyVerify;
use App\Jobs\SendEmailJob;
use App\Jobs\VerificationMail;
use App\Jobs\PaymentJob;
use App\Models\Invitation;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Jobs\SendVerificationEmail;
use function PHPSTORM_META\map;

class CompanyController extends Controller
{
    /**
     * Constructor for using gocardless class
     */
    protected $gocardlessService;

    public function __construct(GoCardlessServices $gocardlessService)
    {
        $this->gocardlessService = $gocardlessService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request) {
            //dd(($request->permission));
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company,
                'permission' => $request->permission,
            ];
            return view('companyregister')->with('data', $data);
        } else {
            return view('companyregister');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * show mandate form
     */
    public function showForm($token)
    {
        return view('email.payment')->with('customer_id', $token);
    }

    /**
     * Show plan buy view
     */
    public function buyplansview($planId)
    {
        //
        $plan = Plan::select('id', 'name', 'price', 'duration')->find($planId);
        return view('buyplan')->with('plan', $plan);
    }
    /**
     * function to buy plan and register user if not registered
     */
    public function buyplan(Request $request)
    {
       
        try {
            $input = $request->all();
            if (!($request->input('user_name'))) {
                $user = Auth::user();
                if ($user->hasRole('Company Subadmin')) {
                    $companyId = session('company_id');
                    $user_Id = Company::where('id', $companyId)->value('user_id');
                    $user = User::where('id', $user_Id)->first();
                }
                $selected_plan = Plan::find($input['id']);
                $user_plan = Plan::find($user->plan_id);
                $priceCents = $selected_plan->price * 100;
                if ($user->subscription_status == 'active') {
                    $data = [
                        "amount" => $priceCents,
                        "currency" => "GBP",
                        "name" => $selected_plan->name,
                        "interval_unit" => $selected_plan->interval_unit,
                        "interval" => $selected_plan->interval,
                        "metadata" => ['user_id' => strval($user->id)],
                        "links" => ["mandate" => $user->mandate_id]
                    ];
                    
                    if ($selected_plan->price > $user_plan->price) {
                        $user_subscription = UserSubscription::where('user_id', $user->id)->first();
                       
                        $this->gocardlessService->createSubscription($data);
                        $user->update(['upgrade_plan_id' => $input['id'], 'upgrade_status' => 'initiated']);
                       
                        return response()->json([
                            'status' => true,
                            'message' => "Subscription Will be added within 4-5 days in your account"
                        ], 200);
                    } else {
                        $users_subscription = UserSubscription::where('user_id', $user->id)->first();
                        $users_subscription->update(['next_plan_id' => $input['id']]);
                    }
                } else {
                    $email = $user->email;
                    $name = $user->name;
                    $session_token = md5(uniqid(rand(), true));
                    $redirect_url = url('complete/redirect/flow/' . $user->id . '/' . $input['id'] . '/' . $session_token);
                    $param = [
                        "session_token" => $session_token,
                        "success_redirect_url" => $redirect_url,
                        "prefilled_customer" =>  [
                            "given_name" => $name,
                            "family_name" => 'Test',
                            "email" => $email,
                        ]
                    ];
                    $redirectFlow = $this->gocardlessService->creatRedirectFlow($param);
                    $data = [
                        'email' => $user->email,
                        'url' => $redirectFlow->redirect_url,
                    ];
                    dispatch(new PaymentJob($data));
                    return response()->json([
                        'status' => true,
                        'message' => "Registation Successfully"
                    ], 200);
                }
            } else {
                $user = User::create([
                    'name' => $input['user_name'],
                    'email' => $input['email'],
                    'password' => $input['password'],
                    'phone' => $input['phone'],
                ]);
                $user->assignRole('Company Admin');
                dispatch(new VerificationMail($user->email));
            }
            if ($request->input('company_name')) {
                if ($request->input('company_email')) {
                    $company =  Company::create([
                        'user_id' =>  $user->id,
                        'company_name' => $input['company_name'],
                        'company_email' => $input['company_email'],
                    ]);
                }
            }
            $email = $user->email;
            $name = $user->name;
            $session_token = md5(uniqid(rand(), true));
            $redirect_url = url('complete/redirect/flow/' . $user->id . '/' . $input['id'] . '/' . $session_token);
            $param = [
                "session_token" => $session_token,
                "success_redirect_url" => $redirect_url,
                "prefilled_customer" =>  [
                    "given_name" => $name,
                    "family_name" => 'Test',
                    "email" => $email,
                ]
            ];
            $redirectFlow = $this->gocardlessService->creatRedirectFlow($param);
            $data = [
                'email' => $user->email,
                'url' => $redirectFlow->redirect_url,
            ];
            dispatch(new PaymentJob($data));
            return response()->json([
                'status' => true,
                'message' => "Registation Successfully"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     *  When customer authorize gocardless then redirect to complete flow with Mandate ID and Customer ID
     */
    public function completeRedirectFlow(Request $request)
    {
        $plan = Plan::find($request->planId);
        $user = User::find($request->userId);
        $params = [["session_token" => $request->session]];
        $redirect_flow_id = $request->redirect_flow_id;
        $params = ["session_token" => $request->session];
        $priceCents = $plan->price * 100;
        $redirectFlow = $this->gocardlessService->completeRedirectFlow($redirect_flow_id, $params);
        $user->update(['mandate_id' => $redirectFlow->links->mandate, 'gc_customer_id' => $redirectFlow->links->customer, 'plan_id' => $request->planId]);
        $data = [
            "amount" => $priceCents,
            "currency" => "GBP",
            "name" => $plan->name,
            "interval_unit" => $plan->interval_unit,
            "interval" => $plan->interval,
            "metadata" => ['user_id' => strval($user->id)],
            "links" => ["mandate" => $user->mandate_id]
        ];
        $subscription = $this->gocardlessService->createSubscription($data);
        // Create mandate link and sent on mail., 
        // check for webhook, when mandate will be created,
        //  you can attach subscription to this account. Till that time, 
        //  save this info in table and once mandate received, update status.
        return redirect($redirectFlow->confirmation_url);
        // dd($redirectFlow->status_code);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRagistrationRequest $request)
    {
        try {
            $input = $request->all();
            $verificationToken = Str::random(60);
            $existingUser = User::where('email', $input['email'])->first();
            $phone = '+' . preg_replace('/[^0-9]/', '', $input['phone']);
            if ($existingUser) {
                $user = $existingUser;
            } else if ($request->company_Id) {
                $user = User::create([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'password' => $input['password'],
                    'phone' => $phone,
                    'company_id' => $request->company_Id,
                    'verification_token' => $verificationToken,
                ]);
                CompanyVerify::dispatch($user, $verificationToken);
                $user->assignRole('Company Subadmin');
              
            } else {
                $phone = '+' . preg_replace('/[^0-9]/', '', $input['phone']);
                $user = User::create([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'password' => $input['password'],
                    'phone' => $phone,
                    'verification_token' => $verificationToken,
                ]);
                $user->assignRole('Company Admin');
            }
            if ($request->has('permission') && !empty($request->permission)) {
                foreach (json_decode($request->permission) as $permission) {
                    // dd($permission);
                    Permissionaccess::create([
                        'user_id' => $user->id,
                        'company_id' => $request->company_Id,
                        'permission_id' => $permission,
                    ]);
                }
            }
            // dd(!($request->company_Id));
            if (!($request->company_Id)) {
                // dd($request->company_Id);
                $imageName = null;
                if ($request->hasfile('logo')) {
                    $image = $request->file('logo');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/assest', $imageName);
                }
                $phone = '+' . preg_replace('/[^0-9]/', '', $input['phone_number']);
                $company =  Company::create([
                    'user_id' =>  $user->id,
                    'company_name' => $input['company_name'],
                    'company_email' => $input['company_email'],
                    'phone_number' => $phone ,
                    'logo' => $imageName,
                ]);
                // dispatch(new VerificationMail($user->email));
                CompanyVerify::dispatch($user, $verificationToken);
            }

            return response()->json([
                'status' => true,
                'message' => "Registation Successfully"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    //     public function store(CompanyRagistrationRequest $request)
    // {
    //     $request->validated();
    //     try {
    //         $input = $request->all();
    //         $existingUser = User::where('email', $input['email'])->first();
    //         if ($existingUser) {
    //             $user = $existingUser;
    //         } else {
    //             $user = User::create([
    //                 'name' => $input['name'],
    //                 'email' => $input['email'],
    //                 'password' => $input['password'],
    //                 'phone' => $input['phone'],
    //             ]);
    //             $user->assignRole('Company Admin');
    //         }


    //         $existingCompany = Company::where('company_email', $input['company_email'])->first();
    //         if ($existingCompany) {

    //             $companyId = $existingCompany->id;
    //         } else {

    //             $image = $request->file('logo');
    //             $imageName = time() . '.' . $image->getClientOriginalExtension();
    //             $image->storeAs('public/assest', $imageName);
    //             $company = Company::create([
    //                 'user_id' => $user->id,
    //                 'company_name' => $input['company_name'],
    //                 'company_email' => $input['company_email'],
    //                 'phone_number' => $input['phone_number'],
    //                 'logo' => $imageName,
    //             ]);

    //             $companyId = $company->id;
    //         }

    //         dispatch(new VerificationMail($user->email));
    //         return response()->json([
    //             'status' => true,
    //             'message' => "Registration Successful",
    //             'company_id' => $companyId 
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    /**
     * function to find company representative
     */
    public function findRepresentative($userId = 0)
    {
        try {
            $user = User::find($userId);
            return response()->json(['status' => true, 'data' => $user]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * to get address details
     */
    // public function getAddress(Request $request, $addressId = 0)
    // {
    //     try {
    //         $address = Address::find($addressId);
    //         return response()->json(['status' => true, 'data' => $address]);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    //     }
    // }
    public function getAddress(Request $request,  $addressId = 0)
{
    try {
        
        $company = Company::find( $addressId);

    
        if (!$company) {
            return response()->json(['status' => false, 'message' => 'Company not found'], 404);
        }

      
        $address = $company->address;

     
        if (!$address) {
            return response()->json(['status' => false, 'message' => 'Address not found for the company','data' => []], 404);
        }

        return response()->json(['status' => true, 'data' => $address]);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
}
    /**
     * to fetch all companies
     */
    public function getCompanies(Request $request)
    {
        try {
            $companies = Company::select(
                'user_id',
                'company_name',
                'company_email',
                'phone_number',
                'description',
                'id'
            );
            $response = [];
            if ($request->requireTotalCount) {
                $response['totalCount'] = $companies->count();
            }
            if (isset($request->take)) {
                $companies->skip($request->skip)->take($request->take);
            }
            if (isset($request->sort)) {
                $sort = json_decode($request->sort, true);
                if (count($sort)) {
                    $companies->orderBy($sort[0]['selector'], ($sort[0]['desc'] ? 'DESC' : 'ASC'));
                }
            } else {
                $companies->orderBy('created_at', 'DESC');
            }
            if ($request->has('filter')) {
                $filters = json_decode($request->filter, true);
                if (count($filters)) {
                    $filters = is_array($filters[0]) ? $filters[0] : $filters;
                    $search = !blank($filters[2]) ? $filters[2] : false;

                    if ($search) {
                        $companies->where('name', 'like', "%$search%");
                    }
                }
            }
            $companyList = $companies->get();
            $response['data'] = $companyList;
            $totalCount = $companies->count();
            if ($companyList->isNotEmpty()) {
                return response()->json([
                    'status' => true,
                    'data' => $companyList,
                    'totalCount' => $totalCount,
                ], 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No Company found',
                ];
                return response()->json($response, 404);
            }
            // return response()->json(['data' => $companies, 'status' => true], 200);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * to update company address
     */
    public function updateAddress(Request $request, $addressId = 0)
    {
        try {
            $address = Address::find($addressId);
            $address->update($request->all());
            return response()->json(['status' => true, 'data' => $address]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            $company = Company::find($id);
            if ($company) {
                $company->update($request->all());
                return response()->json(['status' => true, 'message' => 'Company data updated successfully'], 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Company not found'
                ];
                return response()->json($response, 404);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $company = Company::find($id);
            if ($company) {
                $company->delete();
                $response = [
                    'status' => true,
                    'data' => 'Company deleted Successsfully',
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'no data found',
                ];
                return response()->json($response, 404);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function check(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required',
                'password' => 'required',
                'company_name' => 'required',
            ]);
            if (Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
            ])) {
                $user = Auth::user();
                if ($user->email_verified_at === null) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Email not verified. Please verify your email before logging in.'
                    ], 403);
                }
                if ($user->roles->contains('name', 'Company Subadmin')) {
                    session(['company_id' => $user->company_id]);
                    $companyData = Company::where('id', $user->company_id)->first();
                    return response()->json([
                        'status' => true,
                        'message' => 'Logged in Successfully!',
                        'user_data' => $user,
                        'company_data' => $companyData
                    ], 200);
                }
                if ($user->companies->isNotEmpty()) {
                    foreach ($user->companies as $company) {
                        if ($company->company_name === $credentials['company_name']) {
                            session(['company_id' => $company->id]);
                            $companyData = Company::where('user_id', auth()->id())->where('company_name', $company->company_name)->get();
                            return response()->json([
                                'status' => true,
                                'message' => 'Logged in Successfully!',
                                'user_data' => $user,
                                'company_data' => $companyData
                            ], 200);
                        }
                    }
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Logged in Successfully!',
                    'data' => $user,
                ], 200);
            } else {
                
                return response()->json([
                    'status' => false,
                    'message' => 'Incorrect email or password. Please try again.',
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function logout()
    {
        Auth::logout();
        return response()->json(['status' => true, 'message' => 'Logout Successfully'], 200);
    }
    public function getCompanyNames(Request $request)
    {

        try {
            $user = User::where('email', $request->email)->first();
            // dd($user->hasRole('Company Admin'));
            if ($user->hasRole('Company Admin')) {
                $companies = Company::select('id', 'company_name')->where('user_id', $user->id)->get();
            } else {
                $companies = Company::select('id', 'company_name')->where('id', $user->company_id)->get();
            }

            //$user = User::where('email', $request->email)->first();


            // dd($companies);
            return response()->json([
                'status' => true,
                'companyNames' => $companies,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    // public function getCompanyNames(Request $request)
    // {
    //     try {
    //         $user = User::where('email', $request->email)->first();

    //         if (!$user) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'User not found',
    //             ], 404);
    //         }

    //         // Fetch companies by user_id or company_id
    //         $companies = Company::select('id', 'company_name')
    //             ->where('user_id', $user->id)
    //             ->orWhere('id', $user->company_id)
    //             ->get();

    //         return response()->json([
    //             'status' => true,
    //             'companyNames' => $companies,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'An error occurred: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }



    public function adduser()
    {

        return view('user');
    }
    public function users()
    {
        return view('companyusers');
    }
    // public function fetchuser(Request $request)
    // {

    //     try {
    //         $companyId = session('company_id');
    //         $users = User::where('company_id', $companyId)->get();
    //         return response()->json(['status' => true, 'data' => $users], 200);
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    //     }
    // }
    // public function fetchuser(Request $request)
    // {
    //     try {
    //         $companyId = session('company_id');
    //         $type = $request->input('type');

    //         switch ($type) {
    //             case 'Invited':

    //                 $users = Invitation::where('company_id', $companyId)
    //                     ->where('status', 'pending')
    //                     ->get();
    //                 break;

    //             case 'Rejected':
    //                 $users = Invitation::where('company_id', $companyId)
    //                     ->where('status', 'rejected')
    //                     ->get();
    //                 break;
    //             default:
    //                 $users = User::where('company_id', $companyId)->get();
    //                 break;
    //         }
    //         return response()->json(['status' => true, 'data' => $users], 200);
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    //     }
    // }
    // public function fetchuser(Request $request)
    // {
       
    //     try {
    //         $companyId = session('company_id');
          
    //         $loggedInUserId = auth()->id();

    //         $type = $request->input('type');

    //         switch ($type) {
    //             case 'Invited':
    //                 $users = Invitation::where('company_id', $companyId)
    //                     ->where('status', 'pending');
    //                 break;

    //             case 'Rejected':
    //                 $users = Invitation::where('company_id', $companyId)
    //                     ->where('status', 'rejected');
    //                 break;

    //             default:
    //                 $users = User::where('company_id', $companyId)
    //                     ->where('id', '!=', $loggedInUserId); 
    //                 break;
    //         }
    //         $response = [];
    //         if ($request->requireTotalCount) {
    //             $response['totalCount'] = $users->count();
    //         }
    //         if (isset($request->take)) {
    //             $users->skip($request->skip)->take($request->take);
    //         }
    //         if ($request->has('filter')) {
    //             $filters = json_decode($request->filter, true);
    //             if (count($filters)) {
    //                 $filters = is_array($filters[0]) ? $filters[0] : $filters;
    //                 $search = !blank($filters[2]) ? $filters[2] : false;
    //                 if ($search) {
    //                     $users->where('name', 'like', "%$search%");
    //                 }
    //             }
    //         }
    //         $userList = $users->get();
    //         $response['data'] = $userList;
    //         $totalCount = $users->count();
    //         if ($userList->isNotEmpty()) {
    //             return response()->json([
    //                 'status' => true,
    //                 'data' => $userList,
    //                 'totalCount' => $totalCount,
    //             ], 200);
    //         } else {
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Users not found',
    //                 'totalCount' => $totalCount,
    //             ], 200);
    //         }
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    //     }
    // }
    public function fetchuser(Request $request)
    {
        try {
            $companyId = session('company_id');
            $loggedInUserId = auth()->id();
            $loggedInUser = auth()->user();
    
            $type = $request->input('type');
    
            switch ($type) {
                case 'Invited':
                    $users = Invitation::where('company_id', $companyId)
                        ->where('status', 'pending');
                    break;
    
                case 'Rejected':
                    $users = Invitation::where('company_id', $companyId)
                        ->where('status', 'rejected');
                    break;
    
                default:
                    $users = User::where('company_id', $companyId)
                        ->where('id', '!=', $loggedInUserId); 
                    break;
            }
    
            // Check if logged-in user is not a company admin
            if (!$loggedInUser->hasRole('Company Admin')) {
                $response['totalCount'] = 0;
            } elseif ($request->requireTotalCount) {
                $response['totalCount'] = $users->count();
            }
    
            if (isset($request->take)) {
                $users->skip($request->skip)->take($request->take);
            }
    
            if ($request->has('filter')) {
                $filters = json_decode($request->filter, true);
                if (count($filters)) {
                    $filters = is_array($filters[0]) ? $filters[0] : $filters;
                    $search = !blank($filters[2]) ? $filters[2] : false;
                    if ($search) {
                        $users->where('name', 'like', "%$search%");
                    }
                }
            }
    
            $userList = $users->get();
            $response['data'] = $userList;
            $totalCount = isset($response['totalCount']) ? $response['totalCount'] : $users->count();
    
            if ($userList->isNotEmpty()) {
                return response()->json([
                    'status' => true,
                    'data' => $userList,
                    'totalCount' => $totalCount,
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Users not found',
                    'totalCount' => $totalCount,
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    


    public function userData()
    {
        $user = Auth::user();
        // dd($user);
        $roles = $user->getRoleNames();
        $permissions = $user->permissionaccesses()
            ->with('user.roles', 'permission')
            ->get()
            ->map(function ($item) {
                return $item->permission->name;
            });
        return response()->json(['permissions' => $permissions, 'roles' => $roles]);
    }

    public function fetchPlan()
    {
        $company_id = session('company_id');
        // dd($company_id);
        try {
            $user_Id = Company::where('id', $company_id)->value('user_id');
            $user_subscription = UserSubscription::where('user_id', $user_Id)->first();
            // dd($user_subscription);
            $user_plan = User::where('id', $user_Id)->get()->filter(function ($user) {
                return $user->hasrole('Company Admin');
                // return $user;
            })->value('plan_id');
            $plan = Plan::where('id', $user_plan)->first();
            return response()->json(['status' => true, 'data' => $plan, 'subscription' => $user_subscription], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    //return current plan view with all plan details
    public function showCompanyPlan()
    {
        return view('subscriptiondetails');
    }
    //get all Plans 
    public function getAllPlans()
    {
        try {
            $plans = Plan::all();
            return response()->json(['status' => true, 'data' => $plans], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    public function getCompanyAdmin()
    {
        try {
            $company_id =  session('company_id');
            $company = Company::where('id', $company_id)->first();
            // return $user;
            $user = User::where('id', $company->user_id)->get()->filter(function ($user) {
                return $user->hasrole('Company Admin');
            });
            // dd($user);
            return response()->json(['status' => true, 'data' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    public function cancelUpgradeRequest()
    {
        try {
            $user = Auth::user();
            $user_subscription = UserSubscription::where('user_id', $user->id)->first();
            $this->gocardlessService->removeSubscription($user_subscription->upgrade_subscription_id);
            sleep(8);
            return response()->json(['status' => true, 'message' => 'Canceled Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * function to remove users subscription 
     */
    // public function removeSubscription(Request $request)
    // {
        
    //     try {
    //         $user_subscription = UserSubscription::where('user_id', $request->userID)->first();
    //         $user = User::where('id', $request->userID)->update(['subscription_status' => 'cancelled', 'plan_id' => null]);
    //         $this->gocardlessService->removeSubscription($user_subscription->subscription_id);
    //         return response()->json(['status' => true, 'message' => 'Canceled Successfully'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    //     }
    // }
//     public function removeSubscription(Request $request)
// {
//     try {
//         $user_subscription = UserSubscription::where('user_id', $request->userID)->first();
// dd($user_subscription);
//         if (!$user_subscription || !$user_subscription->subscription_id) {
//             throw new \Exception('Subscription ID is not set or null.');
//         }

//         $user = User::where('id', $request->userID)->update(['subscription_status' => 'cancelled', 'plan_id' => null]);
//         $this->gocardlessService->removeSubscription($user_subscription->subscription_id);

//         return response()->json(['status' => true, 'message' => 'Canceled Successfully'], 200);
//     } catch (\Exception $e) {
//         return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
//     }
// }
public function removeSubscription(Request $request)
{
    try {
        $user_subscription = UserSubscription::where('user_id', $request->userID)->first();
        
        if ($user_subscription) {
            if ($user_subscription->subscription_id) {
             
                $this->gocardlessService->removeSubscription($user_subscription->subscription_id);
                
                User::where('id', $request->userID)->update(['subscription_status' => 'cancelled', 'plan_id' => null]);
            } else {
               
                User::where('id', $request->userID)->update(['subscription_status' => 'cancelled', 'plan_id' => null]);
               
            }
        } else {
            throw new \Exception('User subscription not found.');
        }

        return response()->json(['status' => true, 'message' => 'Canceled Successfully'], 200);
    } catch (\Exception $e) {
       
        return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
}


    public function getTotalPublishedJobs()
    {
        $jobs = Job::getTotalPublishedJobs();
        $totalPublishedJobs = $jobs->count();
        return response()->json(['totalPublishedJobs' => $totalPublishedJobs]);
    }




    public function recentPosts(Request $request)
    {
        try {
            $companyId = session()->get('company_id');
            $company = Company::find($companyId);
            if (!$company) {
                throw new \Exception("Company not found.");
            }
            $recentPosts = $company->jobs()
            ->where('post_status', 'Published') 
            ->latest()
            ->take(5)
            ->get();
        
        // $totalPosts = $company->jobs()->where('post_status', 'Published')->count();
        $totalPosts = $company->jobs()->count(); 
    
            return response()->json(['status' => true, 'data' => $recentPosts, 'total_posts' => $totalPosts], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function totalJobs(Request $request)

    {
        try {
            $companyId = $request->session()->get('company_id');
            $totalJobs = Job::where('company_id', $companyId)
                ->where('post_status', 'Published')
                ->count();
            return response()->json(['status' => true, 'totalJobs' => $totalJobs], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function totalExpiredJobs(Request $request)

    {
        try {
            $companyId = $request->session()->get('company_id');
            $totalJobs = Job::where('company_id', $companyId)
                ->where('post_status', 'Expired')
                ->count();
            return response()->json(['status' => true, 'totalJobs' => $totalJobs], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }


    // public function getPostsAboutToExpire(Request $request)
    // {
    //     $companyId = $request->session()->get('company_id');
    //     $startDate = Carbon::now()->subDays(30); 
    //     $endDate = Carbon::now()->subDays(23);
    
    //     $posts = Job::where('created_at', '<=', $startDate)
    //         ->where('created_at', '>=', $endDate)
    //         ->where('company_id', $companyId)
    //         ->where('post_status', 'Published')
    //         ->get();
           
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Successfully fetched posts about to expire',
    //         'data' => $posts
    //     ], 200);
    // }
    public function getPostsAboutToExpire(Request $request)
{
    $companyId = $request->session()->get('company_id');
    $startDate = Carbon::now()->subDays(23);

    $posts = Job::where('created_at', '<=', $startDate)
        ->where('company_id', $companyId)
        ->where('post_status', 'Published')
        ->get();
       
    return response()->json([
        'success' => true,
        'message' => 'Successfully fetched posts about to expire',
        'data' => $posts
    ], 200);
}

    
    // public function fetchusers(Request $request)
    // {
    //     try {
    //         $companyId = session('company_id');
    //         $type = $request->input('type');

    //         switch ($type) {
    //             case 'Invited':
    //                 $users = Invitation::where('company_id', $companyId)
    //                     ->where('status', 'pending');
    //                 break;

    //             case 'Rejected':
    //                 $users = Invitation::where('company_id', $companyId)
    //                     ->where('status', 'rejected');
    //                 break;
    //             default:
    //                 $users = User::where('company_id', $companyId);
    //                 break;
    //         }
    //         $response = [];
    //         if ($request->requireTotalCount) {
    //             $response['totalCount'] = $users->count();
    //         }
    //         $userList = $users->get();
    //         $response['data'] = $userList;
    //         $totalCount = $users->count();
    //         if ($userList->isNotEmpty()) {
    //             return response()->json([
    //                 'status' => true,
    //                 'data' => $userList,
    //                 'totalCount' => $totalCount,
    //             ], 200);
    //         }
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    //     }
    // }

    public function verifyuser($token)
    {
        $user = User::where('verification_token', $token)->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid verification token',
            ], 400);
        }
        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();
        return redirect('/confirm/company')->with('success', 'Email verified successfully. Please log in.');
        return response()->json([
            'status' => true,
            'message' => 'Email verified successfully',
        ]);
    }
    public function checkCompanyExists(Request $request)
    {
        $companyName = $request->input('company_name');
        $companyEmail = $request->input('company_email');

       
        $existingCompany = Company::where('company_name', $companyName)
                                  ->orWhere('company_email', $companyEmail)
                                  ->first();

        if ($existingCompany) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
}
