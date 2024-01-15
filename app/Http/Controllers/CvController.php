<?php

namespace App\Http\Controllers;

use App\Models\GenerateCV;
use Illuminate\Http\Request;

class CvController extends Controller
{
    public function index()
    {
        return view('cv');
    }

    public function submitForm(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'education' => 'required|string',
                'university' => 'required|string',
                'startYear' => 'required|string',
                'passingYear' => 'required|string',
                'skills' => 'required|string',
                'address' => 'required|string',
            ]);

            $cv = new GenerateCV($validatedData);
            $cv->save();

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
