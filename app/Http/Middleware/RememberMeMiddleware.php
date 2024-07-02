<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class RememberMeMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the user is not authenticated and there's a remember_me cookie
        if (!Auth::check() && $request->hasCookie('user_data')) {
            // Retrieve and decrypt the cookie data
            $encryptedUserData = $request->cookie('user_data');
            $userData = json_decode(decrypt($encryptedUserData), true);

          
            $user = User::find($userData['id']);

           
    if ($user) {
        //   dd($user);
                Auth::login($user);
                return $next($request);
            } else {
             
                Log::warning('Invalid Remember Me Cookie, clearing.');
                Cookie::queue(Cookie::forget('user_data'));
            }
        }
        if (!Auth::check() && $request->hasCookie('company_data')) {
            // Retrieve and decrypt the cookie data
            $encryptedUserData = $request->cookie('company_data');
            $userData = json_decode(decrypt($encryptedUserData), true);

          
            $user = User::find($userData['id']);

           
    if ($user) {
        //   dd($user);
                Auth::login($user);

            
                return $next($request);
            } else {
             
                Log::warning('Invalid Remember Me Cookie, clearing.');
                Cookie::queue(Cookie::forget('company_data'));
            }
        }


        return $next($request);
    }
}

// <?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Cookie;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Str;
// use App\Models\User;
// use Illuminate\Support\Facades\log;
// class RememberMeMiddleware
// {
//     public function handle($request, Closure $next)
//     {
//         if (!Auth::check() && $request->hasCookie('remember_me')) {
//             $cookie = $request->cookie('remember_me');
//            // dd($cookie);
//             $cookieData = json_decode(base64_decode($cookie), true);
//             //dd($cookieData);
//             $user = User::find($cookieData['id']);
//             Log::info('User Object: ' . json_encode($user));
//             // dd($user);
//             if ($user && hash_equals($cookieData['token'], $user->remember_token) && Hash::check($cookieData['password'], $user->password)) {
              
//                 Auth::login($user);
//             } else {
//                 // Invalid cookie, clear it
//                 Cookie::queue(Cookie::forget('remember_me'));
//             }
//         }

//         return $next($request);
//     }
// }

