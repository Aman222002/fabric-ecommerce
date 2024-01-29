<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAchievement;
use Illuminate\Http\Request;

class UserAchievementController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'certification_name' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'certificate_number' => 'required|string|max:255',
                'expiry_date' => 'required|date',

            ]);

            UserAchievement::create([
                'user_id' => auth()->id(),
                'certification_name' => $request->certification_name,
                'company_name' => $request->company_name,
                'certificate_number' => $request->certificate_number,
                'expiry_date' => $request->expiry_date,
                'certificate_file_path' => $request->certificate_file_path,
                // Add other fields as needed
            ]);

            // Retrieve the updated or inserted record
            $userAchievement = UserAchievement::where('user_id', auth()->id())->first();

            return response()->json($userAchievement, 201);
        } catch (\Exception $e) {
            // Handle validation errors or other exceptions
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
