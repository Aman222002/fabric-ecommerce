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
                'user_id' => 'required|exists:users,id',
                'company_name' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
            ]);

            UserExperience::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'user_id' => $request->input('user_id'),
                    'company_name' => $request->input('company_name'),
                    'position' => $request->input('position'),
                    'description' => $request->input('description'),
                    'start_date' => $request->input('start_date'),
                    'end_date' => $request->input('end_date'),
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
