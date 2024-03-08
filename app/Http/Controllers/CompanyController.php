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
use App\Models\UserSubscription;
use App\Http\Requests\CompanyRagistrationRequest;
use App\Jobs\SendEmailJob;
use App\Jobs\VerificationMail;
use App\Jobs\PaymentJob;

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
    public function index()
    {
        //
        return view('companyregister');
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
                $selected_plan = Plan::find($input['id']);
                $user_plan = Plan::find($user->plan_id);
                $priceCents = $selected_plan->price * 100;
                if ($user->subscription_status == 'active') {
                    $data = [
                        "amount" => $priceCents,
                        "currency" => "USD",
                        "name" => $selected_plan->name,
                        "interval_unit" => $selected_plan->interval_unit,
                        "interval" => $selected_plan->interval,
                        "metadata" => ['user_id' => strval($user->id)],
                        "links" => ["mandate" => $user->mandate_id]
                    ];
                    if ($selected_plan->price > $user_plan->price) {
                        // dd($selected_plan);
                        $user_subscription = UserSubscription::where('user_id', $user->id)->first();
                        // $this->gocardlessService->removeSubscription($user_subscription->subscription_id);
                        $this->gocardlessService->createSubscription($data);
                        $user->update(['upgrade_plan_id' => $input['id'], 'upgrade_status' => 'initiated']);
                        // $user_subscription->update(['plan_id' => $input['id']]);
                        // dd($user);
                        return response()->json([
                            'status' => true,
                            'message' => "Subscription Will be added soon in your account"
                        ], 200);
                        // } else if ($selected_plan->name == 'Standard' && $user_plan->name == 'Basic') {
                        //     $this->gocardlessService->createSubscription($data);
                        //     $user->update(['plan_id' => $input['id']]);
                        //     return response()->json([
                        //         'status' => true,
                        //         'message' => "Subscription Will be added soon in your account"
                        //     ], 200);
                        // } 
                    } else {
                        //handling case to downgrade the subscription
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
        $user->update(['mandate_id' => $redirectFlow->links->mandate, 'gc_customer_id' => $redirectFlow->links->customer, 'mandate_status' => 'pending', 'plan_id' => $request->planId]);
        $data = [
            "amount" => $priceCents,
            "currency" => "USD",
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
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRagistrationRequest $request)
    {
        $request->validated();
        try {
            $input = $request->all();
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => $input['password'],
                'phone' => $input['phone'],
            ]);
            $user->assignRole('Company Admin');
            $image = $request->file('logo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/assest', $imageName);
            $company =  Company::create([
                'user_id' =>  $user->id,
                'company_name' => $input['company_name'],
                'company_email' => $input['company_email'],
                'phone_number' => $input['phone_number'],
                'description' => $input['description'],
                'logo' => $imageName,
            ]);
            $company->address()->create([
                'company_id' => $company->id,
                'first_line_address' => $input['first_line_address'],
                'street' => $input['street'],
                'city' => $input['city'],
                'state' => $input['state'],
                'postal_code' => $input['postal_code'],
            ]);
            dispatch(new VerificationMail($user->email));
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
    public function getAddress(Request $request, $addressId = 0)
    {
        try {
            $address = Address::find($addressId);
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
            ]);
            if (Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
            ]))
                $user = Auth::user();
            $roleName = $user->getRoleNames();
            $user->role = $roleName;
            if ($user) {
                if ($user->hasRole('Company Admin')) {
                    $company = Company::where('user_id', $user->id)->first();
                    session(['company_id' => $company->id]);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Logged in Successfully!',
                    'data' => $user,
                ], 200);
            } else {
                Auth::logout();
            }
            return response()->json([
                'status' => false,
                'message' => 'Fail',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    // public function check(Request $request)
    // {
    //     try {
    //         $credentials = $request->validate([
    //             'email' => 'required',
    //             'password' => 'required',
    //             'company_name' => 'required',
    //         ]);
    //         if (Auth::attempt([
    //             'email' => $credentials['email'],
    //             'password' => $credentials['password'],
    //         ])) {
    //             $user = Auth::user();
    //             if ($user->companies->isNotEmpty()) {
    //                 foreach ($user->companies as $company) {
    //                     if ($company->company_name === $credentials['company_name']) {
    //                         session(['company_id' => $company->id]);
    //                         $companyData = Company::where('user_id', auth()->id())->where('company_name', $company->company_name)->get();
    //                         return response()->json([
    //                             'status' => true,
    //                             'message' => 'Logged in Successfully!',
    //                             'user_data' => $user,
    //                             'company_data' => $companyData
    //                         ], 200);
    //                     }
    //                 }
    //             }
    //         }
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Authentication failed',
    //         ], 401);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'An error occurred: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }
    public function logout()
    {
        Auth::logout();
        return response()->json(['status' => true, 'message' => 'Logout Successfully'], 200);
    }
    public function fetchPlan()
    {
        $company_id = session('company_id');
        // dd($company_id);
        try {
            $user_Id = Company::where('id', $company_id)->value('user_id');
            $user_subscription = UserSubscription::where('user_id', $user_Id)->first();
            // dd($user_subscription);
            //return $user->hasrole('Company Admin');
            $user_plan = User::where('id', $user_Id)->get()->filter(function ($user) {
                return $user;
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
            //return $user->hasrole('Company Admin')
            $user = User::where('id', $company->user_id)->get()->filter(function ($user) {
                return $user;
            });
            // dd($user);
            return response()->json(['status' => true, 'data' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    public function cancelUpgradeRequest()
    {
        // dd('user');
        try {
            $user = Auth::user();
            // dd($user);
            // dd($user_subscription);
            $user_subscription = UserSubscription::where('user_id', $user->id)->first();
            $this->gocardlessService->removeSubscription($user_subscription->upgrade_subscription_id);
            $user->update(['upgrade_status' => null,]);
            $user_subscription->update(['upgrade_subscription_id' => null]);
            return response()->json(['status' => true, 'message' => 'Canceled Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
}
