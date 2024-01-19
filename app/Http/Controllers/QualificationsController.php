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
                'user_id' => 'required|exists:users,id',
                'education_type' => 'required|string',
                'school_university' => 'nullable|string',
                'starting_year' => 'nullable|integer|min:1900|max:' . date('Y'), // Adjust the date range as needed
                'passing_year' => 'nullable|integer|min:1900|max:' . date('Y'), // Adjust the date range as needed
                'still_pursuing' => 'nullable|boolean',
                'highest_education_path' => 'nullable|string',
            ]);

            Qualification::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'user_id' => $request->input('user_id'),
                    'education_type' => $request->input('education_type'),
                    'school_university' => $request->input('school_university'),
                    'starting_year' => $request->input('starting_year'),
                    'passing_year' => $request->input('passing_year'),
                    'still_pursuing' => $request->input('still_pursuing'),
                    'degree_path' => $request->input('degree_path'),
                    'dmc_path' => $request->input('dmc_path'),
                    'highest_education_path' => $request->input('highest_education_path'),
                ]
            );

            // Retrieve the updated or inserted record
            $userQualification = Qualification::where('user_id', $request->user_id)->first();

            return response()->json($userQualification, 201);
        } catch (\Exception $e) {
            // Handle validation errors or other exceptions
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
