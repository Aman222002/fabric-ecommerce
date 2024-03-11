<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\UserSkill;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    //
    public function download() {
       
     
        $user = auth()->user();
        $id = $user->id;
       
     
        if ($user == null) {
           
            return response()->json([
                'status' => false,
                'message' => 'No User Found.',
            ], 404);
        }
         $user = User::with(['qualifications', 'userAchievements', 'skills','experience','userProfile','address'])->find($id);
       
        $skill_name=$user->skills->map(function($item){
            $skill=$item->skill;
            return $skill->map(function($data){
                        return $data->skill_name; 
                });
        }); 
        $userdata = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'qualifications' => $user->qualifications,
            'achievements' => $user->userAchievements,
            'skill_name' => $skill_name,
            'experience' => $user->experience,
            'profile' => $user->userProfile,
            'address'=>$user->address
        ];
 
    
        $pdf = Pdf::loadView('pdf', ['userdata' => $userdata]);
        return $pdf->download();
    }
   
}
