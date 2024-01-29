<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Qualification;
use Illuminate\Http\Request;


class QualificationsController extends Controller
{

    public function store(Request $request)
    {
        try {

            $request->validate([
                'education_type' => 'required|string',
                'school_university' => 'nullable|string',
                'starting_year' => 'nullable|integer|min:1900|max:' . date('Y'), // Adjust the date range as needed
                'passing_year' => 'nullable|integer|min:1900|max:' . date('Y'),

            ]);

            Qualification::insert(
                ['user_id' => auth()->id()],
                [
                    'education_type' => $request->education_type,
                    'school_university' => $request->school_university,
                    'starting_year' => $request->starting_year,
                    'passing_year' => $request->passing_year,
                    'still_pursuing' => $request->still_pursuing,
                    'highest_education_path' => $request->highest_education_path,
                ]
            );

            // Retrieve the updated or inserted record
            $userQualification = Qualification::where('user_id', auth()->id())->first();

            return response()->json($userQualification, 201);
        } catch (\Exception $e) {
            // Handle validation errors or other exceptions
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
