<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AdditionalInformation;
use Illuminate\Http\Request;

class AdditionalInformationController extends Controller
{

    public function store(Request $request)
    {
        try {
            $request->validate([
                'hobbies' => 'nullable|string',
                'strengths' => 'nullable|string',
            ]);
            // return $request->all();
            AdditionalInformation::insert(
                // ['user_id' => auth()->id()],
                [
                    'user_id' => auth()->id(),
                    'hobbies' => $request->hobbies,
                    'strengths' => $request->strengths,
                ]
            );

            // Retrieve the updated or inserted record
            $user =  AdditionalInformation::where('user_id', auth()->id())->first();

            return response()->json($user, 201);
        } catch (\Exception $e) {
            // Handle validation errors or other exceptions
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
