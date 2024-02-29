<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserCotroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = User::latest()->paginate(5);
        return view('user.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::pluck('name', 'name')->all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:user.email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = user::create($input);
        $user->assingRole($request->input('roles'));
        return redirect()->route('user.index')->with('success', 'user created Successfully');
    }

    public function updateUser(Request $request, $userId)
    {
        $data = $request->all();

        User::updateOrCreate(['id' => $userId], $data);

        return response()->json(['message' => 'User updated successfully']);
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['user' => $user]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::find($id);
        $roles = Role::pluck('name', 'name',)->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('user.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['passsword']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('modal_has_roles')->where('model_id', $id)->delete();
        $user->assingRole($request->input('roles'));
        return redirect()->route('user.index')->with('success', 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        User::find($id)->delete();
        return redirect()->route('user.index')->with('success', 'User DEleted Successfully');
    }
    /**
     * get users from backend
     */
    public function getUser()
    {

        $user = User::first();

        if ($user) {
            return response()->json([
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
            ]);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
  
}