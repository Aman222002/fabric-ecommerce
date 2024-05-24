<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendVerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            $verificationToken = Str::random(60);
           
            $phone = '+' . preg_replace('/[^0-9]/', '', $input['phone']);
          
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'phone' => $phone,
                'verification_token' => $verificationToken,
            ]);
            $user->assignRole('User');
            SendVerificationEmail::dispatch($user, $verificationToken);
            return response()->json([
                'status' => true,
                'message' => "Registation Successfully",

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function verify($token)
{
    $user = User::where('verification_token', $token)->first();
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid verification token',
        ], 400);
    }
    $user->email_verified_at = now();
    $user->verification_token = null;
    $user->save();
    return redirect('/confirm/user')->with('success', 'Email verified successfully. Please log in.');
    return response()->json([
        'status' => true,
        'message' => 'Email verified successfully',
    ]);
}
public function checkUsername(Request $request)
{
    $username = $request->input('username');
    $user = User::where('name', $username)->first();

    if ($user) {
        return response()->json(['available' => false]);
    }

    return response()->json(['available' => true]);
}
}
