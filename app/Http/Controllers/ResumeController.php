<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Models\User;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:15',
                'country' => 'required|string|max:22',
                'address1' => 'required|string|max:255',
                'user_id' => 'required|exists:users,id',
                'skill_id' => 'required|exists:skills,id',
                'hobbies' => 'nullable|string',
                'strengths' => 'nullable|string',
                'education_type' => 'required|string',
                'school_university' => 'nullable|string',
                'starting_year' => 'nullable|integer|min:1900|max:' . date('Y'),
                'passing_year' => 'nullable|integer|min:1900|max:' . date('Y'),
                'company_name' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
                'certification_name' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'certificate_number' => 'required|string|max:255',
                'expiry_date' => 'required|date',
            ]);
            // return $request->all();
            Resume::insert(
                // ['user_id' => auth()->id()],
                [
                    'user_id' => auth()->id(),
                    'address1' => $request->address1,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'country' => $request->country,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'address2' => $request->address2,
                    'county' => $request->county,
                    'hobbies' => $request->hobbies,
                    'strengths' => $request->strengths,
                    'education_type' => $request->education_type,
                    'school_university' => $request->school_university,
                    'starting_year' => $request->starting_year,
                    'passing_year' => $request->passing_year,
                    'still_pursuing' => $request->still_pursuing,
                    'highest_education_path' => $request->highest_education_path,
                    'certification_name' => $request->certification_name,
                    'company_name' => $request->company_name,
                    'certificate_number' => $request->certificate_number,
                    'expiry_date' => $request->expiry_date,
                    'certificate_file_path' => $request->certificate_file_path,

                ]
            );


            $resume = Resume::where('user_id', auth()->id())->first();

            return response()->json($resume, 201);
        } catch (\Exception $e) {
            // Handle validation errors or other exceptions
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
