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
    public function show()
    {
        $user = auth()->user();
        $userId =  $user->id;
        // dd($user);
        $company = Company::where("user_id",   $userId)->with('address', 'jobs')->get();

        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }
        return response()->json([
            'companydata' => $company,
            'user' => $user
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = auth()->user();
        $userId = $user->id;
        $company = Company::where("user_id", $userId)->get();
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        return response()->json(['companydata' => $company, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $user = auth()->user();
            $userId = $user->id;


            $company = Company::where("user_id", $userId)->first();
            if (!$company) {
                return response()->json(['error' => 'Company not found'], 404);
            }
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ]);
            $image = $request->file('logo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/assest', $imageName);

            $company->update([

                'company_name' => $request->input('company_name'),
                'company_email' => $request->input('company_email'),
                'logo' => $imageName

            ]);
            $address = Address::where('company_id', $company->id)->first();
            if (!$address) {
                return response()->json(['error' => 'Address not found'], 404);
            }

            $address->update([
                'first_line_address' => $request->input('first_line_address'),
                'street' => $request->input('street'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'postal_code' => $request->input('zip_code'),
            ]);




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
    public function updateaddress(Request $request)
    {
        try {
            $user = auth()->user();
            $userId = $user->id;


            $company = Company::where("user_id", $userId)->first();
            if (!$company) {
                return response()->json(['error' => 'Company not found'], 404);
            }



            $address = Address::where('company_id', $company->id)->first();
            if (!$address) {
                return response()->json(['error' => 'Address not found'], 404);
            }

            $address->update([
                'first_line_address' => $request->input('first_line_address'),
                'street' => $request->input('street'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'postal_code' => $request->input('postal_code'),
            ]);
            return response()->json(['message' => 'User and company profiles updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
