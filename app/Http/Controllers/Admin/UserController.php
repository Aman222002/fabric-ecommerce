<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $user = Auth::user();
            if ($user->hasRole('Admin')) {
                $users = User::where('id', '!=', $user->id)->get();
                return response()->json(['data' => $users, 'status' => true], 200);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
                'phone' => 'required|unique:users',
            ]);

            $input = $request->all();
            $user = User::create([
                'name' =>  $input['name'],
                'email' =>  $input['email'],
                'password' =>  Hash::make($input['password']),
                'phone' =>  $input['phone'],
            ]);
            return response()->json(['status' => true, 'message' => 'User created successfully'], 200);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 
    }
    /**
     * function to get logged in user
     */
    public function getProfile()
    {
        try {
            $user = Auth::user();
            if ($user) {
                if ($user->user_image) {
                    $user->user_image = Storage::disk('public')->url('/assets/' . $user->user_image);
                }
                return response()->json(['user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'user_image' => $user->user_image,
                ], 'status' => true], 200);
            } else {
                // Storage::url('assets') . $user->img;
                $response = [
                    'status' => false,
                    'data' => 'User not found',
                ];
                return response()->json($response, 404);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * function to update profile
     */
    public function updateProfile(Request $request, string $id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                $request->validate([
                    'name' => 'required',
                    'email' => 'required',
                    'phone' => 'required',
                    'user_image' => 'image|mimes:jpeg,png,jpg,gif',
                ]);
                if ($request->hasFile('user_image')) {
                    $image = $request->file('user_image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/assets', $imageName);
                }
                $user->update([
                    'user_image' => empty($imageName) ? $user->user_image : $imageName,
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                ]);
                return response()->json(['message' => 'User updated successfully', 'status' => true], 200);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    /**
     * update user password 
     */
    public function updatePassword(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                $request->validate([
                    'current' => 'required',
                    'new' => 'required|min:8',
                ]);
                if (Hash::check($request->input('current'), $user->password)) {
                    $password = Hash::make($request->input('new'));
                    $user->update([
                        'password' => $password,
                    ]);
                    return response()->json(['status' => true, 'message' => 'Password Updated Successfully'], 200);
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Invalid Current Password',
                    ];
                    return response()->json($response, 404);
                }
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    /**
     * Display the data to edit in form
     */
    public function edit(string $id)
    {
        //
        try {
            $user = User::find($id);
            if ($user) {
                return response()->json(['users' => $user, 'status' => true], 200);
            } else {
                $response = [
                    'status' => false,
                    'data' => 'User not found',
                ];
                return response()->json($response, 404);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id = 0)
    {
        //
        try {
            $user = User::find($id);
            if ($user) {
                $user->update($request->all());
                return response()->json(['status' => true, 'message' => 'User updated successfully'], 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'user not found'
                ];
                return response()->json($response, 404);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
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
