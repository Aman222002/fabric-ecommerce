<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Http\Request;

class RegistrationController extends Controller

{
    public function index()
    {
        return view('registration');
    }

    public function  store(Request $request)
    {
        $input = $request->all();
        $response = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'phone' => $input['phone'],
        ]);
        return response()->json([
            'status' => true,
            'message' => "Registation Success"


        ]);
    }
}
