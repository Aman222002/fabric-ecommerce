<?php

namespace App\Http\Controllers;

use App\Jobs\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /**
     * function to return forgetPassword View
     */
    public function forgetPassword()
    {
        return view('forgetpassword');
    }
    /**
     * function to get Link for forget Password
     */
    public function getLink(Request $request)
    {
        $email = $request->email;
        try {
            $user = User::where('email', $email)->first();
            if ($user) {
                $session_token = md5(uniqid(rand(), true));
                $user->update([
                    'reset_token' => $session_token,
                ]);
                $url = url('reset/password/' . $user->id . '/' . $session_token);
                $data = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'url' => $url,
                ];
                dispatch(new ResetPasswordMail($data));
                return response()->json([
                    'status' => true,
                    $token = $user->reset_token,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Please enter a registered email'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * function to show Reset Password Form
     */
    public function showResetPasswordForm(Request $request)
    {
        $data = [
            'id' => $request->user_id,
            'token' => $request->token,
        ];
        try {
            $user = User::where('reset_token', $request->token)->first();
            if ($user) {
                return view('resetpassword')->with(compact('data'));
            } else {
                return view('expired');
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update User Password
     */
    public function updatePassword(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            $password = Hash::make($request->password);
            $user->update(['password' => $password]);
            return response()->json([
                'status' => true,
                'message' => 'Password Updated Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
