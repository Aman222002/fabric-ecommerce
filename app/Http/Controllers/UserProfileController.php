<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $request->validate([
                'hobbies' => 'nullable|string',
                'strengths' => 'nullable|string',
            ]);
            // return $request->all();
            UserProfile::insert(
                // ['user_id' => auth()->id()],
                [
                    'user_id' => auth()->id(),
                    'hobbies' => $request->hobbies,
                    'strengths' => $request->strengths,
                ]
            );

            // Retrieve the updated or inserted record
            $user =  UserProfile::where('user_id', auth()->id())->first();

            return response()->json($user, 201);
        } catch (\Exception $e) {
            // Handle validation errors or other exceptions
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
