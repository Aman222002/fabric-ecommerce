<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserExperience;
use Illuminate\Http\Request;

class UserExperienceController extends Controller
{
    public function store(Request $request)
    {

        try {
            $request->validate([
                'company_name' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
            ]);
            UserExperience::insert(
                [
                    'user_id' => auth()->id(),
                    'company_name' => $request->company_name,
                    'position' => $request->position,
                    'description' => $request->description,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date
                ]
            );

            // Retrieve the updated or inserted record
            $userExperience = UserExperience::where('user_id', $request->user_id)->first();

            return response()->json($userExperience, 201);
        } catch (\Exception $e) {
            // Handle validation errors or other exceptions
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
