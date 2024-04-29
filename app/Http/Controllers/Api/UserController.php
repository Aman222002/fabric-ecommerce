<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Models\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use App\Models\Plan;
use App\Models\Job;
use App\Models\UserAddress;
use App\Models\Skill;
use App\Models\UserProfile;
use App\Models\UserExperience;
use App\Models\UserAchievement;
use App\Models\UserSkill;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Qualification;
use App\Models\Permissionaccess;
use App\Models\Permission;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    
    public function index(Request $request)
    {
        try {
            $user = auth()->user();

            $companyId = 0;

            if ($user->hasRole('Company Admin')) {
                $companyId =  $user->company ? $user->company->id : 0;
            }
            $jobs = Job::with("company");
            if ($companyId != 0) {
                $jobs->where('company_id', $companyId);
            }
            if ($request->type == 'Published') {
                $jobs->where('post_status', $request->type);
            } else if ($request->type == 'Expired') {
                $jobs->where('post_status', $request->type);
            } else if ($request->type == 'Draft') {
                $jobs->where('post_status', $request->type);
            } else if ($request->type == 'All') {
                $jobs;
            }
            $jobs = $jobs->get();
            // $jobs = Job::all();
            return response()->json(['status' => true, 'data' => $jobs], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required',
                'password' => 'required',
                'company_name' => 'required',
            ]);
            if (Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
            ])) {
                $user = Auth::user();
                if ($user->roles->contains('name', 'Company Subadmin')) {
                    $token = $user->createToken('Personal Access Token')->accessToken;
                    session(['company_id' => $user->company_id]);
                    $companyData = Company::where('id', $user->company_id)->first();
                    return response()->json([
                        'status' => true,
                        'message' => 'Logged in Successfully!',
                        'user_data' => $user,
                        'access_token' => $token
                    ], 200);
                }
                if ($user->companies->isNotEmpty()) {
                    foreach ($user->companies as $company) {
                        if ($company->company_name === $credentials['company_name']) {
                            $token = $user->createToken('Personal Access Token')->accessToken;
                            session(['company_id' => $company->id]);
                            $companyData = Company::where('user_id', auth()->id())->where('company_name', $company->company_name)->get();
                            return response()->json([
                                'status' => true,
                                'message' => 'Logged in Successfully!',
                                'user_data' => $user,
                               
                                'access_token' => $token
                            ], 200);
                        }
                    }
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Logged in Successfully!',
                    'data' => $user,
                ], 200);
            } else {
                Auth::logout();
            }
            return response()->json([
                'status' => false,
                'message' => 'Authentication failed',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function getUserData(Request $request)
    {
        try {
            $user = auth()->user();
           
            $userProfile = UserProfile::where('user_id', $user->id)->first();
            
            $userSkillIds = UserSkill::where('user_id', $user->id)->pluck('skill_id');
            $userSkills = Skill::whereIn('id', $userSkillIds)->get();
            $userExperience = UserExperience::where('user_id', $user->id)->get();
            $userAchievment = UserAchievement::where('user_id', $user->id)->get();
            $userQualification = Qualification::where('user_id', $user->id)->get();
            $userAddress = UserAddress::where('user_id', auth()->id())->first();
         
            $response = [
                "status" => true,
                "data" => [
                    "userDetails" => ["name" => $user->name, "email" => $user->email, "phone" => $user->phone,"user_image" =>$user->user_image,"status" => $user->status],
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

    

    
    public function store(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['status' => false, 'message' => 'Unauthenticated'], 401);
            }
            $user = auth()->user();
            $company = $user->company->id;
           if(!($user->hasRole('Company Admin'))){
            dd($user);
            $company = $user->company_id;
            if (!$company) {
                return response()->json(['status' => false, 'message' => 'User does not belong to a company'], 404);
            }
            $permission = Permission::where('name', 'Post Job')->first();
        
            if (!$permission) {
                return response()->json(['status' => false, 'message' => 'Permission not found'], 404);
            }
            
            $permissionAccess = PermissionAccess::where('company_id', $company)
                                ->where('user_id', $user->id)
                                ->where('permission_id', $permission->id)
                                ->first();
                            
            if (!$permissionAccess) {
                return response()->json(['status' => false, 'message' => 'User does not have permission to post a job'], 403);
            }
            
           }
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'category' => 'required',
                'jobType' => 'required',
                'vacancy' => 'required|integer',
                'location' => 'required',
                'experience' => 'required|string',
                'companywebsite' => 'required|url',
                'description' => 'required',
                'salary' => 'required',
                'jobSkill' => 'required',
                'qualifications'=>'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 422);
            }
        
            $category = Category::where('name', $request->input('category'))->first();
        if (!$category) {
            return response()->json(['status' => false, 'message' => 'Category not found'], 404);
        }
       
        $jobtype = JobType::where('name', $request->input('jobType'))->first();
        if (!$jobtype) {
            return response()->json(['status' => false, 'message' => 'Job Type not found'], 404);
        }
        $skill = Skill::where('skill_name', $request->input('jobSkill'))->first();
        if (!$skill) {
            return response()->json(['status' => false, 'message' => 'Jobskill not found'], 404);
        }
            $userId = $request->userId ?? $user->id;
    
            $input = $request->only(['title', 'category', 'jobType', 'vacancy', 'location', 'experience', 'companywebsite', 'description', 'salary', 'jobSkill','qualifications']);
       
          
            $job = Job::create([
                'user_id' => $user->id,
                'company_id' => $company,
                'title' => $request->input('title'),
                'category_id' => $category->id,
                'job_type_id' => $jobtype->id,
                'vacancy' => $request->input('vacancy'),
                'location' => $request->input('location'),
                'experience' => $request->input('experience'),
                'company_website' => $request->input('companywebsite'),
                'description' => $request->input('description'),
                'salary' => $request->input('salary'), 
                'post_status' => 'Published',
                'skill_id' => $skill->id,
                'qualifications' => $request->input('qualifications'),
            ]);
            $jobUrl = url('/view/' . $job->id); 
            return response()->json([
                'status' => true,
                'message' => 'Posted successfully',
                'data' => $job,
                'job_url' => $jobUrl,
            ], 201,[], JSON_UNESCAPED_SLASHES);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function show(user $user)
    {
       
    }


public function update(Request $request, $slug)
{
    try {
        $job = Job::where('slug', $slug)->first(); 

        if (!$job) {
            return response()->json(['status' => false, 'message' => 'No job found with the provided slug'], 404);
        }

       
        if (!Auth::check()) {
            return response()->json(['status' => false, 'message' => 'Unauthenticated'], 401);
        }
        
       
        $user = auth()->user();

        
        if (!$user->hasRole('Company Admin')) {
            
            if ($job->user_id != $user->id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized to edit this job'], 403);
            }
        }

        if (!$user->hasRole('Company Admin')) {
          
            $company = $user->company_id;
            
            if (!$company) {
                return response()->json(['status' => false, 'message' => 'User does not belong to a company'], 404);
            }
            
            $permission = Permission::where('name', 'Edit Job')->first();
            
            if (!$permission) {
                return response()->json(['status' => false, 'message' => 'Permission not found'], 404);
            }
            
          
            $permissionAccess = PermissionAccess::where('company_id', $company)
                ->where('user_id', $user->id)
                ->where('permission_id', $permission->id)
                ->first();
                            
            if (!$permissionAccess) {
                return response()->json(['status' => false, 'message' => 'User does not have permission to edit a job'], 403);
            }
        }

        $input = $request->all();
        $job->update($input);

        $response = [
            'status' => true,
            'data' => $job,
        ];
        return response()->json($response, 200);
    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
}

    
public function destroy($slug)
{
    try {
        $job = Job::where('slug', $slug)->first();

        if (!$job) {
            return response()->json(['status' => false, 'message' => 'No job found with the provided slug'], 404);
        }

        if (!Auth::check()) {
            return response()->json(['status' => false, 'message' => 'Unauthenticated'], 401);
        }
        
        $user = auth()->user();

        if (!$user->hasRole('Company Admin')) {
           
            if ($job->user_id != $user->id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized to delete this job'], 403);
            }
        }

        if (!$user->hasRole('Company Admin')) {
           
            $company = $user->company_id;
            
            if (!$company) {
                return response()->json(['status' => false, 'message' => 'User does not belong to a company'], 404);
            }
            
            $permission = Permission::where('name', 'Edit Job')->first();
            
            if (!$permission) {
                return response()->json(['status' => false, 'message' => 'Permission not found'], 404);
            }
            
          
            $permissionAccess = PermissionAccess::where('company_id', $company)
                ->where('user_id', $user->id)
                ->where('permission_id', $permission->id)
                ->first();
                            
            if (!$permissionAccess) {
                return response()->json(['status' => false, 'message' => 'User does not have permission to delete a job'], 403);
            }
        }
        $job->delete();

        $response = [
            'status' => true,
            'message' => 'Job deleted successfully',
        ];
        return response()->json($response, 200);

    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
}

}
