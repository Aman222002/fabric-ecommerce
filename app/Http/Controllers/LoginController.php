<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Hash;

class LoginController extends Controller
{
    // use AuthenticatesUsers;
    // protected $redirectTo = '/cv';
    public function index()
    {
        return view('login');
    }

    public function  check(Request $request)
    {
        try {
            $credential = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
            return response()->json([
                'status' => true,
                'message' => "Login Success",

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
