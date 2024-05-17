<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Job;
use App\Models\User;
use App\Models\Skill;
use App\Models\UserSkill;
use Carbon\Carbon;

class SearchjobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request);
        if ($request->jobTitle || $request->location || $request->category) {
            $data = [
                'title' => $request->jobTitle,
                'location' => $request->location,
                'category' => $request->category,
            ];
            //
        } else {
            $data = [];
        }
        // eturn view('companypost');
        return view('companypost')->with('data', $data);
    }


    public function fetchJob()
    {
        try {
            // $jobs = Job::all();
            $user = auth()->user();
            $skills = UserSkill::where('user_id', $user->id)->pluck('skill_id');
            $companyId = 0;
            if ($user->hasRole('User')) {
                $companyId =  $user->company ? $user->company->id : 0;
            }
            $jobs = Job::whereIn('skill_id', $skills)->with("company");
            if ($companyId != 0) {
                $jobs->where('company_id', $companyId);
            }
            // dd($jobs);
            $jobs = $jobs->get()->filter(function ($job) {
                $user_id = $job->user_id;
                // dd($job);
                $subscription_status = User::where('id', $user_id)->value('subscription_status');
                if ($subscription_status == 'active' && $job->post_status == 'Published') {
                    return $job;
                } else {
                    return false;
                }
            });
            // dd($jobs);
            return response()->json(['status' => true, 'data' => $jobs], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }


    // public function fetchData()
    // {
    //     try {
    //         // $jobs = Job::all();
    //         $user = auth()->user();
    //         $skills = UserSkill::where('user_id', $user->id)->pluck('skill_id');
    //         $companyId = 0;
    //         if ($user->hasRole('User')) {
    //             $companyId =  $user->company ? $user->company->id : 0;
    //         }
    //         $jobs = Job::whereIn('skill_id', $skills)->with("company");
    //         if ($companyId != 0) {
    //             $jobs->where('company_id', $companyId);
    //         }
    //         // dd($jobs);
    //         $jobs = $jobs->get()->filter(function ($job) {
    //             $user_id = $job->user_id;
    //             // dd($job);
    //             $subscription_status = User::where('id', $user_id)->value('subscription_status');
    //             if ($subscription_status == 'active' && $job->post_status == 'Published') {
    //                 return $job;
    //             } else {
    //                 return false;
    //             }
    //         });
    //         // dd($jobs);
    //         return response()->json(['status' => true, 'data' => $jobs], 200);
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    //     }

    // }
    public function fetchData()
    {
        try {

            $jobs = Job::with('company', 'jobType', 'category')->get();
            $jobs = $jobs->filter(function ($job) {
                $user_id = $job->user_id;
                $subscription_status = User::where('id', $user_id)->value('subscription_status');
                if ($subscription_status == 'active' && $job->post_status == 'Published') {
                    return $job;
                } else {
                    return false;
                }
            });

            return response()->json(['status' => true, 'data' => $jobs], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function searchJobs(Request $request)
    {
        try {
            $jobs = Job::with("company");
            if ($request->has('jobTitle')) {
                $jobs->where('title', 'like', '%' . $request->input('jobTitle') . '%')->where(function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('subscription_status', 'active');
                    })->where('post_status', 'Published');
                })
                    ->get();
            }
            if ($request->has('location')) {
                $jobs->where('location', 'like', '%' . $request->input('location') . '%')->where(function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('subscription_status', 'active');
                    })->where('post_status', 'Published');
                })
                    ->get();;
            }
            if ($request->has('experience')) {
                $jobs->where('experience', 'like', '%' . $request->input('experience') . '%')->where(function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('subscription_status', 'active');
                    })->where('post_status', 'Published');
                })
                    ->get();;
            }
            if ($request->has('category')) {
               
                $category_id = Category::where('name', $request->category)->value('id');
              
                $jobs = $jobs->where('category_id', 'like', '%' . $category_id . '%')
                    ->where(function ($query) {
                        $query->whereHas('user', function ($query) {
                            $query->where('subscription_status', 'active');
                        })->where('post_status', 'Published');
                    })
                    ->get();
            }
            if ($jobs->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'No jobs found.'], 404);
            }
            return response()->json(['status' => true, 'data' => $jobs], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function viewjob($jobid)
    {

        return view('viewjob')->with('jobid', $jobid);
    }
    public function fetchJobDetails($jobid)
    {

        try {
            $job = Job::with('company.socialMediaAccounts', 'company.address', 'jobType', 'category')->find($jobid);

            if (!$job) {
                return response()->json(['status' => false, 'message' => 'Job not found.'], 404);
            }

            $user_id = $job->user_id;
            $subscription_status = User::where('id', $user_id)->value('subscription_status');
            if ($subscription_status != 'active' || $job->post_status != 'Published') {
                return response()->json(['status' => false, 'message' => 'Job is not available.'], 404);
            }
            $skillName = Skill::where('id', $job->skill_id)->value('skill_name');

            $job->skill_name = $skillName;

            return response()->json(['status' => true, 'data' => $job], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
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
