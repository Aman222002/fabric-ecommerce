<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationEmail;
use App\Models\Invitation;
use App\Models\Permission;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        try {
            $user = Auth::user();
            if ($user->hasRole('Admin')) {
                $users = User::where('id', '!=', $user->id);
            }
            $response = [];
            if ($request->requireTotalCount) {
                $response['totalCount'] = $users->count();
            }
            if (isset($request->take)) {
                $users->skip($request->skip)->take($request->take);
            }
            if (isset($request->sort)) {
                $sort = json_decode($request->sort, true);
                if (count($sort)) {
                    $users->orderBy($sort[0]['selector'], ($sort[0]['desc'] ? 'DESC' : 'ASC'));
                }
            } else {
                $users->orderBy('created_at', 'DESC');
            }
            if ($request->has('filter')) {
                $filters = json_decode($request->filter, true);
                if (count($filters)) {
                    $filters = is_array($filters[0]) ? $filters[0] : $filters;
                    $search = !blank($filters[2]) ? $filters[2] : false;

                    if ($search) {
                        $users->where('name', 'like', "%$search%");
                    }
                }
                // dd($users);
            }
            $userList = $users->get();
            $response['data'] = $userList;
            $totalCount = $users->count();
            if ($userList->isNotEmpty()) {
                return response()->json([
                    'status' => true,
                    'data' => $userList,
                    'totalCount' => $totalCount,
                ], 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No Product found',
                ];
                return response()->json($response, 404);
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
            $company_id = session('company_id');
         
            $user = User::create([
                'name' =>  $input['name'],
                'email' =>  $input['email'],
                'password' =>  Hash::make($input['password']),
                'phone' =>  $input['phone'],
                'company_id' => $company_id,
            ]);
            $user->assignRole('Company Admin');
           
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
    public function updatestatus(Request $request)
    {
        try {
            $data = $request->all();
            $userId = Auth::id();
            $status = min($data['progressPercentage'], 100); 
            User::where('id', $userId)->update(['status' => $status]);
            return response()->json(['message' => 'Step updated successfully'],200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update step'], 500);
        }
    }



    public function addnewuser(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|unique:users',
                'phone' => 'required|unique:users', 
                'permission' => 'required |array',
            ]);
            
            $permissionIds = [];
            foreach ($request->input('permission') as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();
                if (!$permission) {
                    return response()->json(['status' => false, 'message' => 'Permission not found'], 404);
                }
                $permissionIds[] = $permission->id;
            }
        //    dd($permissionIds);
            $invitedUser = Invitation::create([
                'user_email' => $request->input('email'),
                'status' => 'pending'
            ]);
            $input = $request->all();
            $company_id = session('company_id');
            $company = Company::find($company_id);
            if (!$company) {
                return response()->json(['status' => false, 'message' => 'Company not found'], 404);
            }
            $url = url('/accepted/'.$invitedUser->id);
            $url2 = url('/reject/'.$invitedUser->id);
            Mail::to($input['email'])->send(new InvitationEmail($input['name'], $input['email'], $input['phone'], $company->id, $permissionIds, $url, $url2));
            return response()->json(['status' => true, 'message' => 'User created successfully'], 200);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    
    public function accept(Request $request)
    {
    //   dd(urldecode($request->permission));
        try {
            $user = Invitation::find($request->id);
            $user->status = 'accepted';
            $user->update();

            $existingUser = User::where('email', $user->user_email)->first();

            if (!$existingUser) {
              //  $serializedPermissions = urlencode(serialize($permissions));
         
                $url =  url('/company/register/'.$request->id .'/'.$request->name .'/'.$request->email. '/'.$request->phone. '/'.$request->company. '/'.$request->permission);
                return redirect($url);

            }
            else{
                
                return redirect('/company/register');
            }
            return response()->json(['status' => true, 'message' => 'Invitation accepted successfully'], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    public function reject(Request $request)
    {
        try {
            $user = Invitation::find($request->invitation_id);
            $user->status = 'rejected';
            $user->update();
            return response()->json(['status' => true, 'message' => 'Invitation rejected successfully'], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    
    
}
