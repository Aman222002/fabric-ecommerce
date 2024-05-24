<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\UserSkill;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    //
    public function download(Request $request) {
        $selectedTemplate = $request->input('template');
    
        // Assuming you have logic to determine the user here, I'm using auth() for simplicity
        $user = auth()->user();
        $id = $user->id;
    
        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'No User Found.',
            ], 404);
        }
    
        $user = User::with(['qualifications', 'userAchievements', 'skills', 'experience', 'userProfile', 'address'])->find($id);
    
        $skill_name = $user->skills->map(function ($item) {
            $skill = $item->skill;
            return $skill->map(function ($data) {
                return $data->skill_name;
            });
        });
        $userdata = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'user_image' => $user->user_image,
            'qualifications' => $user->qualifications,
            'achievements' => $user->userAchievements,
            'skill_name' => $skill_name,
            'experience' => $user->experience,
            'profile' => $user->userProfile,
            'address' => $user->address
        ];
        
        try {
            $viewName = 'pdf1';
    
           
            if ($selectedTemplate === 'Template2') {
                $viewName = 'pdf2';
            }
            if ($selectedTemplate === 'Template3') {
                $viewName = 'pdf3';
            }
            $pdf = Pdf::loadView($viewName, ['userdata' => $userdata]);
            return $pdf->download();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error generating PDF.',
            ], 500);
        }
    }
    public function preview($template)
    {
        
    
        // Assuming you have logic to determine the user here, I'm using auth() for simplicity
        $user = auth()->user();
        $id = $user->id;
    
        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'No User Found.',
            ], 404);
        }
        $user = User::with(['qualifications', 'userAchievements', 'skills', 'experience', 'userProfile', 'address'])->find($id);
    
        $skill_name = $user->skills->map(function ($item) {
            $skill = $item->skill;
            return $skill->map(function ($data) {
                return $data->skill_name;
            });
        });

        
        $userdata = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'user_image' => $user->user_image,
            'qualifications' => $user->qualifications,
            'achievements' => $user->userAchievements,
            'skill_name' => $skill_name,
            'experience' => $user->experience,
            'profile' => $user->userProfile,
            'address' => $user->address
        ];

       
        $viewName = 'pdf1'; 
        if ($template === 'Template2') {
            $viewName = 'pdf2';
        } elseif ($template === 'Template3') {
            $viewName = 'pdf3';
        }
        try {
            $pdf = PDF::loadView($viewName, ['userdata' => $userdata]);
            return $pdf->stream(); 
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Error generating PDF preview.',
            ], 500);
        }
    }
    
   
}
