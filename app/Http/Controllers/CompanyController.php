<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Requests\CompanyRagistrationRequest;
use App\Jobs\SendEmailJob;
use App\Jobs\VerificationMail;

class CompanyController extends Controller
{
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
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function check(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required',
                'password' => 'required|email',
            ]);

            if (Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
            ]))
                $user = Auth::user();
            $roleName = $user->getRoleNames();
            $user->role = $roleName; {
                if (Auth::user()->hasRole('Company Admin')) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Logged in Successfully!',
                        'data' => $user,
                    ], 200);
                } else {
                    Auth::logout();
                }
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
}
