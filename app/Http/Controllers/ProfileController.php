<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Address;
use App\Models\Job;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('companyprofile');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // public function show()
    // {
    //     $user = auth()->user();
    //     $userId =  $user->id;
        
    //     $company = Company::where("user_id", $userId)
    //         ->with(['address', 'jobs' => function ($query) {
    //             $query->where('is_draft', 0);
    //         }])
    //         ->get();

    //     if (!$company) {
    //         return response()->json(['error' => 'Company not found'], 404);
    //     }
    //     return response()->json([
    //         'companydata' => $company,
    //         'user' => $user
    //     ]);
    // }
    public function show()
    {
        try {
            $companyId = session('company_id');
    
            if (!$companyId) {
                return response()->json(['error' => 'Company ID not found in session'], 404);
            }
    
            $company = Company::with(['address','socialMediaAccounts', 'jobs' => function ($query) {
                $query->where('is_draft', 0);
            }])->find($companyId);
    
            if (!$company) {
                return response()->json(['error' => 'Company not found'], 404);
            }
    
            $user = auth()->user();
    
            return response()->json([
                'companydata' => $company,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        try {
            $companyId = session('company_id');
    
            if (!$companyId) {
                return response()->json(['error' => 'Company ID not found in session'], 404);
            }
    
            $user = auth()->user();
    
            $company = Company::where("id", $companyId)->first();
    
            if (!$company) {
                return response()->json(['error' => 'Company not found'], 404);
            }
    
            return response()->json(['companydata' => $company, 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $companyId = session('company_id');
    
            if (!$companyId) {
                return response()->json(['error' => 'Company ID not found in session'], 404);
            }
    
            $user = auth()->user();
    
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ]);
    
            $company = Company::find($companyId);
    
            if (!$company) {
                return response()->json(['error' => 'Company not found'], 404);
            }
    
            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/assest', $imageName);
    
                $company->update([
                    'company_name' => $request->input('company_name'),
                    'company_email' => $request->input('company_email'),
                    'logo' => $imageName
                ]);
            } else {
                $company->update([
                    'company_name' => $request->input('company_name'),
                    'company_email' => $request->input('company_email'),
                ]);
            }
    
            return response()->json(['message' => 'User and company profiles updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    // public function job()
    // {
    //     try {
    //         $user = auth()->user();

    //         $companyId = 0;

    //         if($user->hasRole('Company Admin')){
    //             $companyId =  $user->company ? $user->company->id : 0;
    //         }
    //         $jobs = Job::with("company");

    //         if($companyId != 0){
    //             $jobs->where('company_id', $companyId);
    //         }
    //         $jobs =   $jobs->get();

    //         // $jobs = Job::all();
    //         return response()->json(['status' => true, 'data' => $jobs], 200);
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    //     }
    // }
    public function updateAddress(Request $request)
    {
        try {
            $companyId = session('company_id');
    
            if (!$companyId) {
                return response()->json(['error' => 'Company ID not found in session'], 404);
            }
    
            Address::updateOrCreate(
                ['company_id' => $companyId],
                [
                    'first_line_address' => $request->input('first_line_address'),
                    'street' => $request->input('street'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'postal_code' => $request->input('postal_code'),
                ]
            );
    
            return response()->json(['message' => 'Address updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function updatedescription(Request $request)
    {
        try {
            $companyId = session('company_id');
    
            if (!$companyId) {
                return response()->json(['error' => 'Company ID not found in session'], 404);
            }
    
            $company = Company::find($companyId);
    
            if (!$company) {
                return response()->json(['error' => 'Company not found'], 404);
            }
    
            $company->update([
                'description' => $request->input('description'),
            ]);
    
            return response()->json(['message' => 'Description updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
