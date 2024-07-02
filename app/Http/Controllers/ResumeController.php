<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\log;
use App\Models\UserAddress;
use App\Models\User;
use App\Models\Skill;
use App\Models\UserProfile;
use App\Models\UserExperience;
use App\Models\UserAchievement;
use App\Models\UserSkill;
use Carbon\Carbon;

use App\Models\Address;
use App\Models\Qualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    public function store(Request $request)
    {
      //dd($request);
        try {
            $user = auth()->user();

            $request->validate([
                // 'user_id' => 'required|exists:users,id',
                'address.address1' => 'required|string|max:255',
                'address.city' => 'required|string|max:255',
                'address.state' => 'required|string|max:255',
                'address.zip_code' => 'required|string|max:15',
                'address.country' => 'required|string|max:22',
                'address.latitude' => 'nullable|string',
                'address.longitude' => 'nullable|string',
                'selectedSkills' => 'required|string',
                // 'skill_ids' => 'required|array',
                // 'skill_ids.*' => 'exists:skills,id',
                // 'skill_id' => 'required|exists:skills,id',
                'userProfile.hobbies' => 'nullable|string',
                'userProfile.strengths' => 'nullable|string',
                'educationDetails.*.education_type' => 'required|string',
                'educationDetails.*.school_university' => 'nullable|string',
                'educationDetails.*.starting_year' => 'nullable|integer|min:1900|max:' . date('Y'),
                'educationDetails.*.passing_year' => 'nullable|integer|min:1900|max:' . date('Y'),
                // 'experience.*.company_name' => 'required|string|max:255',
                // 'experience.*.position' => 'required|string|max:255',
                // 'experience.*.description' => 'required|string',
                // 'experience.*.start_date' => 'required|date',
                // 'experience.*.end_date' => 'nullable|date',
                // 'achievements.*.certification_name' => 'required|string|max:255',
                // 'achievements.*.company_name' => 'required|string|max:255',
                // 'achievements.*.certificate_number' => 'required|string|max:255',
                // 'achievements.*.expiry_date' => 'required|date',
                // 'achievements.*.certificate_file_path' => 'required|mimes:pdf|max:2048'

            ]);
// if ($request->has('userDetails.user_image')) {
    
//     $image = $request->userDetails['user_image'];
//     $imageName = time() . '.' . $image->getClientOriginalExtension();
//     $image->storeAs('public/assest', $imageName);
//     $userId = $user->id;
//     $user = User::find($userId);
//     if ($user) {
//         $user->user_image = $imageName;
//         $user->save();
//     }  
// }
// else{
//     $newImage = $request->userDetails['user_image']; 
//     $user->user_image = $newImage;
//    $user->save();  
// }
if ($request->hasFile('userDetails.user_image')) { 
    $image = $request->file('userDetails.user_image'); 
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $image->storeAs('public/assest', $imageName);
    $userId = $user->id;
    $user = User::find($userId);
    if ($user) {
        $user->user_image = $imageName;
        $user->save();
    }  
} else {
    if (isset($request->userDetails['user_image'])) {
        $newImage = $request->userDetails['user_image']; 
        $userId = $user->id;
        $user = User::find($userId);
        if ($user) {
            $user->user_image = $newImage;
            $user->save();  
        }
    }
}



//dd($request);
            UserAddress::updateOrInsert(
                [
                    'user_id' => $user->id,
                ],
                [
                    'user_id' => $user->id,
                    'address1' => $request->address['address1'],
                    'city' => $request->address['city'],
                    'state' => $request->address['state'],
                    'zip_code' => $request->address['zip_code'],
                    'country' => $request->address['country'],
                    'latitude' => $request->address['latitude'],
                    'longitude' => $request->address['longitude'],
                    'address2' => $request->address['address2'],
                    'county' => $request->address['county'],
                ]
            );
            // $skills = $request->selectedSkills ? json_decode($request->selectedSkills, 1) : [];

            // $alteredSkills = [];
            // foreach ($skills as $skill) {
            //     $alteredSkills[] = ['user_id' => $user->id, 'skill_id' => $skill];
            // }
            // if (count($alteredSkills)) {
            //     UserSkill::upsert(
            //         $alteredSkills,
            //         ['user_id', 'skill_id'],
            //         ['skill_id']
            //     );
            // }
           // dd($request);
            // $skills = $request->selectedSkills ? json_decode($request->selectedSkills, 1) : [];

            // $alteredSkills = [];
            // foreach ($skills as $skill) {

            //     $existingSkill = Skill::find($skill);
            //     if ($existingSkill) {
            //         $alteredSkills[] = ['user_id' => $user->id, 'skill_id' => $skill];
            //     }
            // }
          
            // if (count($alteredSkills)) {
            //     UserSkill::upsert(
            //         $alteredSkills,
            //         ['user_id', 'skill_id'],
            //         ['skill_id']
            //     );
            // }


            // $existingSkills = UserSkill::where('user_id', $user->id)->pluck('skill_id')->toArray();
            // $skillsToDelete = array_diff($existingSkills, $skills);
   


            // if (!empty($skillsToDelete)) {
            //     UserSkill::where('user_id', $user->id)
            //         ->whereIn('skill_id', $skillsToDelete)
            //         ->delete();
            // }
            $skills = $request->selectedSkills ? json_decode($request->selectedSkills, true) : [];

            // If no skills are selected, create new entries for all
            if (empty($skills)) {
                // Upsert all selected skills
                foreach ($skills as $skill) {
                    UserSkill::updateOrCreate(
                        ['user_id' => $user->id, 'skill_id' => $skill],
                        ['user_id' => $user->id, 'skill_id' => $skill]
                    );
                }
            } else {
                $existingSkills = UserSkill::where('user_id', $user->id)->pluck('skill_id')->toArray();
            
                $alteredSkills = [];
                foreach ($skills as $skill) {
                    $existingSkill = Skill::find($skill);
                    if ($existingSkill) {
                        $alteredSkills[] = ['user_id' => $user->id, 'skill_id' => $skill];
                    }
                }
            
                // Upsert new or updated skills
                if (count($alteredSkills) > 0) {
                    UserSkill::upsert(
                        $alteredSkills,
                        ['user_id', 'skill_id'],
                        ['skill_id']
                    );
                }
            
                // Determine skills to delete
                $skillsToDelete = array_diff($existingSkills, $skills);
            
                // Delete skills that are no longer selected
                if (!empty($skillsToDelete)) {
                    UserSkill::where('user_id', $user->id)
                        ->whereIn('skill_id', $skillsToDelete)
                        ->delete();
                }
            }
            

            

            UserProfile::updateOrInsert(
                ['user_id' => $user->id],
                [
                    'hobbies' => $request->userProfile['hobbies'],
                    'strengths' => $request->userProfile['strengths'],
                ]
            );
            // if (is_array($request->educationDetails) && count($request->educationDetails) > 0 && is_array($request->educationDetails[0])) {
            //     $qualificationData = [];
            //     foreach ($request->educationDetails as $educationDetail) {
            //         $educationDetail['user_id'] = $user->id;
            //         // qualification::updateOrCreate(['user_id' => $user->id, 'education_type' => $educationDetail['education_type']], ['education_type' => $educationDetail['education_type'], 'starting_year' => $educationDetail['starting_year'], 'passing_year' => $educationDetail['passing_year'], 'school_university' => $educationDetail['school_university']]);
            //         $qualificationData[] = $educationDetail;
            //     }
            //     Log::info('data' . json_encode($qualificationData));
            //     // dd($qualificationData);
            //     Qualification::upsert(
            //         $qualificationData,
            //         ['user_id', 'education_type'],
            //         ['education_type', 'starting_year', 'passing_year', 'still_pursuing', 'school_university']
            //     );
            // }
            if (is_array($request->educationDetails) && count($request->educationDetails) > 0 && is_array($request->educationDetails[0])) {
                $qualificationData = [];
                // Store user_id in a variable
                $userId = $user->id;
                $data = array_map(function ($educationDetail) use ($userId) {
                    return [
                        'user_id' => $userId,
                        'education_type' => $educationDetail['education_type'],
                        'starting_year' => $educationDetail['starting_year'],
                        'passing_year' => $educationDetail['passing_year'],
                        'still_pursuing' => $educationDetail['still_pursuing'] ?? 0,
                        'school_university' => $educationDetail['school_university']
                    ];
                }, $request->educationDetails);
                Qualification::upsert(
                    $data,
                    ['user_id', 'education_type'],
                );
            }
            if (is_array($request->experience) && count($request->experience) > 0 && is_array($request->experience[0])) {
                $experienceData = [];
                foreach ($request->experience as $experiences) {
                    $experiences['user_id'] = $user->id;
                    if ($experiences['start_date'] == 'null' || is_null($experiences['start_date'])) {
                        $experiences['start_date'] = NULL;
                    }
                    if ($experiences['end_date'] == 'null' || is_null($experiences['end_date'])) {
                        $experiences['end_date'] = NULL;
                    }
                    
                    $experienceData[] = $experiences;
                }
                foreach ($experienceData as $experience) {
                    $user_id = $user->id;
                    Log::debug('Experience data:', $experience);
                    UserExperience::where('user_id', $user_id)
                        ->whereNull('company_name')
                        ->delete();
                    $result =  UserExperience::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'company_name' => $experience['company_name'],
                        ],
                        [
                            'position' => $experience['position'],
                            'description' => $experience['description'],
                            'start_date' => $experience['start_date'],
                            'end_date' => $experience['end_date'],
                            'currently_working' => $experience['currently_working'] ?? false
                        ]
                    );
                }
            }
            if (is_array($request->achievements) && count($request->achievements) > 0 && is_array($request->achievements[0])) {
                $achievementData = [];
                foreach ($request->achievements as $achievement) {
                    $achievement['user_id'] = $user->id;

                    if ($achievement['certificate_file_path'] instanceof \Illuminate\Http\UploadedFile) {
                        $certificate_file = $achievement['certificate_file_path'];
                        $certificate_file_path_name = "file_" . time() . '.' . $certificate_file->getClientOriginalExtension();
                        \Illuminate\Support\Facades\Storage::disk('public')->put('assets/files/' . $certificate_file_path_name, file_get_contents($certificate_file));

                        $achievement['certificate_file_path'] = $certificate_file_path_name;
                    }
                    $achievementData[] = $achievement;
                }
                foreach ($achievementData as $achievement) {

                    $user_id = $user->id;
                    UserAchievement::where('user_id', $user_id)
                        ->whereNull('company_name')
                        ->delete();
                    UserAchievement::upsert(
                        $achievementData,
                        [
                            'user_id' => $user->id,
                            'certification_name' => $achievement['certification_name'],
                        ],
                        ['certification_name', 'company_name', 'certificate_number', 'expiry_date', 'certificate_file_path']
                    );
                }
            }
            $userSkill = UserSkill::where('user_id', $user->id)->get()->pluck('skill_id');

            //$userInfo =  UserProfile::where('user_id', $user->id)->first();
            $userProfile = UserProfile::where('user_id', $user->id)->first();
            $userExperience = UserExperience::where('user_id', $user->id)->get();
            $userAchievment = UserAchievement::where('user_id', $user->id)->get();
            $userQualification = Qualification::where('user_id', $user->id)->get();
            $userAddress = UserAddress::where('user_id', auth()->id())->first();
            //dd( $userExperience);
            $user->name = $request->userDetails['name'];
            $user->email = $request->userDetails['email'];
            $user->phone = $request->userDetails['phone']; 
            $user->country_code ='+' .$request->userDetails['country_code']; // Update phone number here
   
    // $user->user_image =$request->userDetails['user_image'];
    //   dd($user);
            $user->save();
            $response = [
                "status" => true,
                "data" => [
                    "userDetails" => ["name" => $user->name, "email" => $user->email, "phone" => $user->phone, "user_image" => $user->user_image],
                    "address" => $userAddress,
                    "educationDetails" => $userQualification,
                    "experience" => $userExperience,
                    "achievements" => $userAchievment,
                    "userProfile" => $userProfile,
                    "selectedSkills" => $userSkill

                ]
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {

            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function getUserData(Request $request)
    {
        try {
            $user = auth()->user();
            //dd($user);
            $userProfile = UserProfile::where('user_id', $user->id)->first();
            // $userSkill = UserSkill::where('user_id', $user->id)->get()->pluck('skill_id');
            $userSkillIds = UserSkill::where('user_id', $user->id)->pluck('skill_id');
            $userSkills = Skill::whereIn('id', $userSkillIds)->get();
            $userExperience = UserExperience::where('user_id', $user->id)->get();
            $userAchievment = UserAchievement::where('user_id', $user->id)->get();
            $userQualification = Qualification::where('user_id', $user->id)->get();
            $userAddress = UserAddress::where('user_id', auth()->id())->first();

            $response = [
                "status" => true,
                "data" => [
                    "userDetails" => ["name" => $user->name, "email" => $user->email, "phone" => $user->phone, "user_image" => $user->user_image, "status" => $user->status,"country_code"=>$user->country_code],
                    "address" => $userAddress,
                    "educationDetails" => $userQualification,
                    "experience" => $userExperience,
                    "achievements" => $userAchievment,
                    "userProfile" => $userProfile,
                    "skills" => $userSkills,
                ]

            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {

            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroyEducation($id)
    {
        try {
            $id = Qualification::find($id);


            if ($id) {
                $id->delete();
                $response = [
                    'status' => true,
                    'message' => 'delted deleted successfully',
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No data found',
                ];
                return response()->json($response, 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function destroyExperience($id)
    {
        try {

            $id = UserExperience::find($id);

            if ($id) {
                $id->delete();
                $response = [
                    'status' => true,
                    'message' => 'delted deleted successfully',
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No data found',
                ];
                return response()->json($response, 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function destroyAchievment($id)
    {
        try {

            $id = UserAchievement::find($id);

            if ($id) {
                $id->delete();
                $response = [
                    'status' => true,
                    'message' => 'delted deleted successfully',
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No data found',
                ];
                return response()->json($response, 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
