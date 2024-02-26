<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\log;
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
    /**
     * function to return forgetPassword View
     */
    public function forgetPassword()
    {
        return view('ForgetPassword');
    }
    /**
     * function to get Link for forget Password
     */
    public function getLink(Request $request)
    {
        $email = $request->email;
    }
    public function  check(Request $request)
    {

        $credential = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        try {
            if (Auth::attempt($credential)) {
                $user = Auth::user();
                if ($user) {
                    $user->getRoleNames();
                    return response()->json(['status' => true, 'data' => $user]);
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'No data found',
                    ];
                    return response()->json($response, 404);
                }
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Invalid Credentials',
                ];
                return response()->json($response, 500);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function getUser()
    {
        try {
            $user = Auth::user();
            if ($user) {
                $role = $user->getRoleNames();
                return response()->json(['status' => true, 'data' => $user], 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No data found',
                ];
                return response()->json($response, 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
