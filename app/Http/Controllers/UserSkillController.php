<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSkill;
use Illuminate\Http\Request;

class UserSkillController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'skill_name' => 'required|string|max:255',
            ]);

            Skill::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'user_id' => $request->input('user_id'),
                    'skill_name' => $request->input('skill_name'),
                ]
            );

            // Retrieve the updated or inserted record
            $skill = Skill::where('user_id', $request->user_id)->first();

            return response()->json($skill, 201);
        } catch (\Exception $e) {
            // Handle validation errors or other exceptions
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
