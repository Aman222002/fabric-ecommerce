<?php

namespace App\Http\Controllers\Api;

use App\Models\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use App\Models\Plan;
use App\Models\Job;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required|exists:categories,id',
            'jobType' => 'required|exists:job_types,id',
            'vacancy' => 'required|integer',
            'location' => 'required',
            'experience' => 'required|string',
            'companywebsite' => 'required|url',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 422);
        }
        
        try {
            $companyId = session('company_id');
            
            if (!$companyId) {
                return response()->json(['status' => false, 'message' => 'Company ID not found in session'], 422);
            }
            $user_Id = Company::where('id', $companyId)->value('user_id');
            // $user = User::where('id', $user_Id)->get()->filter(function ($user) {
            //     return $user->hasrole('Company Admin');
            //     // return $user;
            // });
            $user = User::where('id', $user_Id)->whereHas('roles', function ($query) {
                $query->where('name', 'Company Admin');
            })->first();
            if (!($user->subscription_status == 'active')) {
                return response()->json([
                    'status' => false,
                    'message' => 'User does not have a active subscription plan'
                ], 402);
            }
            $posts_allowed = Plan::where('id', $user->plan_id)->value('Posts_Allowed');
            $job_posted = Job::where('user_id', $user->id)->where('post_status', 'Published')->count();
            if ($posts_allowed < ($job_posted + 1)) {
                return response()->json([
                    'status' => false,
                    'message' => `User exceeds posts allowed`
                ], 403);
            }
            $company = $user->company;
            $input = $request->all();
            
            $job = Job::create([
                'user_id' => $user->id,
                'company_id' => $company->id,
                'title' => $input['title'],
                'category_id' => $input['category'],
                'job_type_id' => $input['jobType'],
                'vacancy' => $input['vacancy'],
                'salary' => $input['salary'],
                'location' => $input['location'],
                'description' => $input['description'],
                'qualifications' => $input['qualifications'],
                'experience' => $input['experience'],
                'company_website' => $input['companywebsite'],
                'post_status' => 'Published',
                'skill_id' => $input['jobSkill'],
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Posted successfully',
                'data' => $job,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $job = Job::find($id);

            if ($job) {
                $input = $request->all();
                $job->update(['post_status', 'Published']);
                $job->update($input);
                $response = [
                    'status' => true,
                    'data' => $job,
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $job = Job::find($id);
            if ($job) {
                $job->delete();
                $response = [
                    'status' => true,
                    'message' => 'Job deleted successfully',
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
