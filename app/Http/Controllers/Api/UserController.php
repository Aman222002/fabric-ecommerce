<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use app\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //     protected $user;
    //     public function __construct()
    //     {
    //         $this->user = new User();
    //     }
    //     public function index()
    //     {
    //         //
    //         return $this->user->all();
    //     }

    //     /**
    //      * Store a newly created resource in storage.
    //      */
    //     public function store(Request $request)
    //     {
    //         //
    //         return $this->user->create($request->all());
    //     }

    //     /**
    //      * Display the specified resource.
    //      */
    //     public function show(string $id)
    //     {
    //         //
    //         $user = $this->user->find($id);
    //     }

    //     /**
    //      * Update the specified resource in storage.
    //      */
    //     public function update(Request $request, string $id)
    //     {
    //         //
    //         $user = $this->user->find($id);
    //         $user->update($request->all());
    //         return $user;
    //     }

    //     /**
    //      * Remove the specified resource from storage.
    //      */
    //     public function destroy(string $id)
    //     {
    //         //
    //         $user = $this->user->find($id);
    //         return $user->delete();
    //     }
    // }
    public function index()
    {
        $users = User::all();
        //return array_reverse($users);
        return view('admin.index');
    }
    public function store(Request $request)
    {
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'Confirm_password' => $request->input('Confirm_password'),
        ]);
        $user->save();
        return response()->json('User created!');
    }
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }
    public function update($id, Request $request)
    {
        $user = User::find($id);
        $user->update($request->all());
        return response()->json('User updated!');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json('User deleted!');
    }
}
