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
    public function logout()
    {
        Auth::logout();
        return response()->json(['status' => true, 'message' => 'Logout Successfully'], 200);
    }
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                $user->delete();
                $response = [
                    'status' => true,
                    'data' => 'User deleted Successsfully',
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
}
