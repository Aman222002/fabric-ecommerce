<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AdditionalInformation;
use Illuminate\Http\Request;

class AdditionalInformationController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'hobbies' => 'nullable|string',
            'achievements' => 'nullable|string',
            'strengths' => 'nullable|string',
        ]);
        $user = AdditionalInformation::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'hobbies' => $request->input('hobbies'),
                'achievements' => $request->input('achievements'),
                'strengths' => $request->input('strengths'),
            ]
        );
    }
}
