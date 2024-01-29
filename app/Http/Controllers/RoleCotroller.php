<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Backtrace\Arguments\ReducedArgument\ReducedArgument;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleCotroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware(['permission:role-list|role-create|role-edit|role-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:role-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:role-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:role-delete'], ['only' => ['destroy']]);
    }
    public function index()
    {
        //
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $permission = Permission::get();
        return view('roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:roles,names',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index')->with('success', 'Role created successfully');
        /**
         * Display the specified resource.
         */
    }
    public function show(string $id)
    {
        //
        $role = Role::find($id);
        $rolePermissions = Permission::json("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")->where("role_has_permissions.role_id", $id)->get();
        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermisssions = DB::table("role_has_permissions")->where("role_has_ permissions.role_id", $id)->pluck('role_ has_permission_id', 'role_has_permission.permission_id')->all();
        return view('roles.edit', compact('role', 'rolePermissions'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permissions'));
        return redirect()->route('roles.index')->with('success', 'Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'Role Deleted Successfully');
    }
}
