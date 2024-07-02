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
// use Hash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    // use AuthenticatesUsers;
    // protected $redirectTo = '/cv';
    // public function index(Request $request)
    // {
    //     dd($request);
    //     return view('login');
    // }
    public function index(Request $request)
{
    // Check if the user_data cookie exists
    if ($request->hasCookie('user_data')) {
   
        $encryptedUserData = $request->cookie('user_data');
        $userData = json_decode(decrypt($encryptedUserData), true);

        //dd( $userData);
        if (isset($userData['email']) && isset($userData['password'])) {
            $email = $userData['email'];
            $password = $userData['password'];

    
            return view('login', compact('email', 'password'));
        }
    }

  
    return view('login');
}

    // public function check(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);
    
    //     // Attempt to authenticate the user
    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    
    //         if ($user->hasRole('Admin')) {
               
    //             $user->getRoleNames(); 
    //             return response()->json(['status' => true, 'data' => $user]);
    //         }
    
    //         if ($user->email_verified_at !== null) {
    //             $user->getRoleNames(); 
    //             return response()->json(['status' => true, 'data' => $user]);
    //         } else {
             
    //             Auth::logout();
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Email not verified. Please verify your email before logging in.'
    //             ], 403);
    //         }
    //     } else {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid Credentials',
    //         ], 500);
    //     }
    // }
//     public function check(Request $request)
// {
//     //dd($request);
//     $credentials = $request->validate([
//         'email' => ['required', 'email'],
//         'password' => ['required'],
//     ]);
//     $rememberMe = $request->has('remember_me') ? true : false;

//     if (Auth::attempt($credentials, $rememberMe)) {
//         $user = Auth::user();

//         if ($rememberMe) {
          
//             $token = Str::random(60);
//             // dd($token);
//             $user->remember_token = $token;
//             //  dd($user->remember_token);
//             $user->save();
            
//             $cookieData = [
//                 'id' => $user->id,
//                 'token' => $user->remember_token, 
//                 'password' => $user->password,
//             ];
//             $cookieValue = base64_encode(json_encode($cookieData));
//             $cookie = cookie('remember_me', $cookieValue, 30 * 24 * 60); // 30 days
//         }

//         if ($user->hasRole('Admin')) {
//             $user->getRoleNames();
//             return response()->json(['status' => true, 'data' => $user])->cookie($cookie ?? null);
//         }

//         if ($user->email_verified_at !== null) {
//             $user->getRoleNames();
//             return response()->json(['status' => true, 'data' => $user])->cookie($cookie ?? null);
//         } else {
//             Auth::logout();
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Email not verified. Please verify your email before logging in.'
//             ], 403);
//         }
//     } else {
//         return response()->json([
//             'status' => false,
//             'message' => 'Invalid Credentials',
//         ], 500);
//     }
// }
public function check(Request $request)
{
   //dd($request);
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // $remember = $request->filled('remember');
    $remember = $request->boolean('rememberMe');
    // Attempt to authenticate the user
    if (Auth::attempt($credentials, $remember)) {
        $user = Auth::user();

        if ($user->hasRole('Admin') || $user->email_verified_at !== null) {
            $user->load('roles'); // Ensure roles are loaded if not eager loaded
         
                $userData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $request->password, // Ensure this is handled securely
                ];
          
         
                // $userData = [
                //     'id' => $user->id,
                //     'name' => $user->name,
                //     'email' => $user->email,
                //     'password' => $request->password, 
                // ];
                if ($remember) {
                    $user->update(['remember_token' => Str::random(60)]);
                    $encryptedUserData = encrypt(json_encode($userData));
                    $cookie = Cookie::make('user_data', $encryptedUserData,7 * 24 * 60); 
                    return response()->json([
                        'status' => true,
                        'data' => $user,
                    ])->withCookie($cookie);
         
                   
                } else {
                    $user->update(['remember_token' => null]); // Remove remember token if not checked
                }
        // dd($cookie);
            // Return JSON response with user data
            return response()->json([
                'status' => true,
                'data' => $user,
            ]);
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
// public function check(Request $request)
// {
//     $credentials = $request->validate([
//         'email' => ['required', 'email'],
//         'password' => ['required'],
//     ]);
    
//     $rememberMe = $request->has('remember_me'); // true or false

//     if (Auth::attempt($credentials, $rememberMe)) {
//         $user = Auth::user();

//         if ($rememberMe && empty($user->remember_token)) {
//             $token = Str::random(60);
//             $user->forceFill([
//                 'remember_token' => $token,
//             ])->save();
           
//             $cookieValue = base64_encode(json_encode([
//                 'id' => $user->id,
//                 'token' => $token,
//                 'password' => $user->password,
//             ]));
            
//             $cookie = cookie('remember_me', $cookieValue, 60 * 24 * 30); // 30 days
//         } else {
//             $cookie = null; // Ensure $cookie is defined as null if not needed
//         }

//         if ($user->hasRole('Admin') || $user->email_verified_at !== null) {
//             $user->getRoleNames();
//             return response()->json(['status' => true, 'data' => $user])->cookie($cookie);
//         } else {
//             Auth::logout();
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Email not verified. Please verify your email before logging in.'
//             ], 403);
//         }
//     } else {
//         return response()->json([
//             'status' => false,
//             'message' => 'Invalid Credentials',
//         ], 500);
//     }
// }
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
        ->where('company_name', '!=', 'null')
        ->exists();
           
        //dd( $workExperienceExists);
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
