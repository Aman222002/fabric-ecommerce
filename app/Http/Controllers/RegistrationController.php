<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class RegistrationController extends Controller

{
    public function index()
    {
        return view('registration');
    }

    public function  store(Request $request)
    {
        try {

            $input = $request->all();
            User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'phone' => $input['phone'],
            ]);

            return response()->json([
                'status' => true,
                'message' => "Registation Success",

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
