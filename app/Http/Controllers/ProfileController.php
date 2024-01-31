<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
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
        $company = Company::where("user_id",   $userId)->get();

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
       
        return response()->json(['message' => 'User and company profiles updated successfully']);
    }catch (\Exception $e) {
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
}
