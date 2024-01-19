<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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
    public function store(Request $request)
    {
        $validationRules = [
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|unique:companies|max:255',
            'registration_number' => 'required|string|max:255|unique:companies',
            'company_address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ];
        $request->validate($validationRules);
        //
        try {
            $input = $request->all();
           $user = User::create([
            'name'=>$input['name'],
            'email'=>$input['email'],
            'password'=>$input['password'],
            'phone'=>$input['phone'],
           ]);
           $user->assignRole('Company Admin');
            Company::create([
                 'user_id'=>  $user->id,
                'company_name' => $input['company_name'],
                'company_email' => $input['company_email'],
                'registration_number' => $input['registration_number'],
                'company_address' => $input['company_address'],
                'phone_number' => $input['phone_number'],
                'description' => $input['description'],
                'status' => $input['status'],
            ]);
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
            {
                if (Auth::user()->hasRole('Company Admin')) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Logged in Successfully!',
                        'data' => [
                            'user' => $user,
                            'role' => $roleName,
                        ],
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
