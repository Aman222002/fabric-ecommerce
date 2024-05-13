<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\log;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserExperience;
use App\Models\UserAchievement;
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
    public function check(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            if ($user->hasRole('Admin')) {
               
                $user->getRoleNames(); 
                return response()->json(['status' => true, 'data' => $user]);
            }
    
            if ($user->email_verified_at !== null) {
                $user->getRoleNames(); 
                return response()->json(['status' => true, 'data' => $user]);
            } else {
             
                Auth::logout();
                return response()->json([
                    'status' => false,
                    'message' => 'Email not verified. Please verify your email before logging in.'
                ], 403);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials',
            ], 500);
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
    public function getSkills($userId)
    {
        try {
            // Fetch the user based on the user ID
            $user = User::findOrFail($userId);

            // Fetch the user's skills using the 'skills' relationship
            $userSkills = $user->skills;

            // Transform the user skills to only include the skill details
            $skills = $userSkills->map(function ($userSkill) {
                return $userSkill->skill;
            });

            return response()->json($skills);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch user skills.'], 500);
        }
    }
    public function fetchUserData()
    {
        $workExperienceExists = UserExperience::where('user_id', auth()->id())
            ->whereNotNull('company_name')
            ->exists();
    
        $userAchievementsExists = UserAchievement::where('user_id', auth()->id())->exists();
    
        return response()->json([
            'workExperienceExists' => $workExperienceExists,
            'userAchievementsExists' => $userAchievementsExists,
        ]);
    }
    public function index2()
    {
       
        $userId = auth()->id();
    
        
        $experiences = UserExperience::where('user_id', $userId)->get();
    
      
        return response()->json($experiences);
    }
    
}
