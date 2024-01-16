<?php

namespace App\Http\Controllers;

use App\Models\GenerateCV;
use Illuminate\Http\Request;

class CvController extends Controller
{
    public function index()
    {
        return view('generate_cv');
    }

    public function submitForm(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string|max:10',
                'hobbies' => 'required|string',
                'highest_education' => 'required|string',
                'university' => 'required|string',
                'starting_year' => 'required|string',
                'passing_year' => 'required|string',
                'skills' => 'required|string',
                'address' => 'required|string',
            ]);

            $validatedData['user_id'] = auth()->id();
            $cv = GenerateCv::create($validatedData);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images', $imageName);
                $cv->image = $imageName;
                $cv->save();
            }
            return response()->json(['message' => 'CV submitted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'CV submission failed', 'error' => $e->getMessage()], 500);
        }
    }
}
