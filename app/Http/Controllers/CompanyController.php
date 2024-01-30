<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            $company =  Company::create([
                'user_id' =>  $user->id,
                'company_name' => $input['company_name'],
                'company_email' => $input['company_email'],
                'phone_number' => $input['phone_number'],
                'description' => $input['description'],
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
     * to get address details
     */
    public function getAddress(Request $request, $addressId = 0)
    {
        try {
            $address = \App\Models\Address::find($addressId);
            return response()->json(['status' => true, 'data' => $address]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * to fetch all companies
     */
    public function getCompanies()
    {
        try {
            $companies = Company::all();
            return response()->json(['data' => $companies, 'status' => true], 200);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

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
