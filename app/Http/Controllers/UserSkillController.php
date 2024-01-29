<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\log;
use App\Models\User;
use App\Models\Skill;
use App\Models\UserSkill;
use Illuminate\Http\Request;

class UserSkillController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'skill_id' => 'required|exists:skills,id',
            ]);

            UserSkill::create([
                'user_id' => $request->user_id,
                'skill_id' => $request->skill_id,
            ]);

            return response()->json(['message' => 'Skill saved successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
