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
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;
    public function index()
    {
        return view('login');
    }

    public function  check(Request $request)
    {

        $credential = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credential)) {


            return response()->json([
                'status' => true,
                'message' => " Success"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "fail"
            ]);
        }
    }
}
