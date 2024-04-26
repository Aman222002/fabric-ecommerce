<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Permission;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $jobSkills = Skill::all();
    
            
            if ($jobSkills->isEmpty()) {
                return response()->json(['message' => 'No job types found'], 404);
            }
    
            return response()->json($jobSkills);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving job types', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function permission()
    {
        //
        try {
            $userpermission = Permission::all();
    
            
            if ($userpermission->isEmpty()) {
                return response()->json(['message' => 'No  types found'], 404);
            }
    
            return response()->json( $userpermission);
           
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving job types', 'error' => $e->getMessage()], 500);
        }
    }
    public function getUserSkills(Request $request)
    {
        $user = $request->user();
        $skills = $user->skills;

        // Return the skills as JSON response
        return response()->json($skills);
    }
}
