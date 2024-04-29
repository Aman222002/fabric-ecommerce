<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialMediaAccount;
use Illuminate\Validation\ValidationException;
class SocialMediaAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function updateSocialMedia(Request $request)
    {
        try {
            // Check if the authenticated user has the role of company admin
            if (!auth()->user()->hasRole('Company Admin')) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
    
            $this->validate($request, [
                'facebook' => 'nullable|url',
                'twitter' => 'nullable|url',
                'linkedin' => 'nullable|url',
                'instagram' => 'nullable|url',
            ]);
    
            $companyId = session('company_id');
            $socialMedia = SocialMediaAccount::updateOrCreate(
                ['company_id' => $companyId],
                [
                    'facebook_url' => $request->input('facebook'),
                    'twitter_url' => $request->input('twitter'),
                    'linkedin_url' => $request->input('linkedin'),
                    'instagram_url' => $request->input('instagram'),
                ]
            );
    
            return response()->json(['message' => 'Social media details updated successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update social media details'], 500);
        }
    }
    


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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
