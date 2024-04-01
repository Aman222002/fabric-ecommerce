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
                'experience.*.company_name' => 'required|string|max:255',
                'experience.*.position' => 'required|string|max:255',
                'experience.*.description' => 'required|string',
                // 'experience.*.start_date' => 'required|date',
                // 'experience.*.end_date' => 'nullable|date',
                'achievements.*.certification_name' => 'required|string|max:255',
                'achievements.*.company_name' => 'required|string|max:255',
                'achievements.*.certificate_number' => 'required|string|max:255',
                'achievements.*.expiry_date' => 'required|date',
                // 'achievements.*.certificate_file_path' => 'required|mimes:pdf|max:2048'

            ]);
            $image = $request->userDetails['user_image'];
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/assest', $imageName);
            $userId = $user->id;
            $user = User::find($userId);
            if ($user) {
                $user->user_image = $imageName;
                $user->save();
            }
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
            $skills = $request->selectedSkills ? json_decode($request->selectedSkills, 1) : [];

            $alteredSkills = [];
            foreach ($skills as $skill) {
                $alteredSkills[] = ['user_id' => $user->id, 'skill_id' => $skill];
            }
            if (count($alteredSkills)) {
                UserSkill::upsert(
                    $alteredSkills,
                    ['user_id', 'skill_id'],
                    ['skill_id']
                );
            }
            UserProfile::updateOrInsert(
                ['user_id' => $user->id],
                [
                    'hobbies' => $request->userProfile['hobbies'],
                    'strengths' => $request->userProfile['strengths'],
                ]
            );
            if (is_array($request->educationDetails) && count($request->educationDetails) > 0 && is_array($request->educationDetails[0])) {
                $qualificationData = [];
                foreach ($request->educationDetails as $educationDetail) {
                    $educationDetail['user_id'] = $user->id;
                    // qualification::updateOrCreate(['user_id' => $user->id, 'education_type' => $educationDetail['education_type']], ['education_type' => $educationDetail['education_type'], 'starting_year' => $educationDetail['starting_year'], 'passing_year' => $educationDetail['passing_year'], 'school_university' => $educationDetail['school_university']]);
                    $qualificationData[] = $educationDetail;
                }
                Log::info('data' . json_encode($qualificationData));
                Qualification::upsert(
                    $qualificationData,
                    [
                        'user_id', 'education_type'
                    ],
                    ['education_type', 'starting_year', 'passing_year', 'still_pursuing', 'school_university']
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
                // 'company_name' => $experiences['company_name'],
                Log::info('data' . json_encode($experiences['company_name']));
                UserExperience::upsert(
                    $experienceData,
                    [
                        'user_id' => $user->id,
                        'company_name' => $experiences['company_name'],
                    ],
                    ['company_name', 'position', 'description', 'start_date', 'end_date']
                );
                // dd($experienceData);
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

                UserAchievement::upsert(
                    $achievementData,
                    [
                        'user_id' => $user->id,
                        'certification_name' => $achievement['certification_name'],
                    ],
                    ['certification_name', 'company_name', 'certificate_number', 'expiry_date', 'certificate_file_path']
                );
            }
            $userSkill = UserSkill::where('user_id', $user->id)->get()->pluck('skill_id');

            //$userInfo =  UserProfile::where('user_id', $user->id)->first();
            $userProfile = UserProfile::where('user_id', $user->id)->first();
            $userExperience = UserExperience::where('user_id', $user->id)->get();
            $userAchievment = UserAchievement::where('user_id', $user->id)->get();
            $userQualification = Qualification::where('user_id', $user->id)->get();
            $userAddress = UserAddress::where('user_id', auth()->id())->first();
            //dd( $userExperience);

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
                    "userDetails" => ["name" => $user->name, "email" => $user->email, "phone" => $user->phone, "user_image" => $user->user_image, "status" => $user->status],
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

            return response()->json(['sttaus' => false, 'message' => $e->getMessage()], 500);
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
