<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use App\Models\SavedJob;
use App\Models\Company;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApply;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobNotificationEmail;
use App\Models\User;
use App\Models\Plan;
use Carbon\Carbon;


class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        try {
            $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
            $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

            if ($categories->isEmpty() || $jobTypes->isEmpty()) {
                return response()->json(['message' => 'No categories or job types found', 'status' => false], 404);
            } else {

                return response()->json([
                    'categories' => $categories,
                    'jobTypes' => $jobTypes,
                    'status' => true,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving data', 'error' => $e->getMessage(), 'status' => false], 500);
        }
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
    public function show($id)
    {
        try {
            $job = Job::find($id);

            if ($job) {
                return response()->json(['status' => true, 'data' => $job], 200);
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
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id = 0)
    {

        try {
            $job = Job::find($id);

            if ($job) {
                return response()->json(['status' => true, 'data' => $job], 200);
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

    public function applyJob(Request $request)
    {
        try {
            $id = $request->id;
            $job = Job::where('id', $id)->first();
            $company_website = $job->company_website;
            $company_id = $job->company_id;
            $jobApplicationCount = JobApply::where([
                'user_id' => Auth::user()->id,
                'job_id' => $id
            ])->count();

            if ($jobApplicationCount > 0) {
                $message = 'You already applied on this job.';
                return response()->json([
                    'status' => false,
                    'message' => $message
                ], 500);
            }
            $application = new JobApply();
            $application->job_id = $id;
            $application->user_id = Auth::user()->id;
            $application->company_id = $company_id;
            $application->applied_date = now();
            $application->save();
            $company = Company::where('id', $company_id)->first();

            $mailData = [
                'company' => $company,
                'user' => Auth::user(),
                'job' => $job,
            ];
            Mail::to($company->company_email)->send(new JobNotificationEmail($mailData));
            $message = 'You have successfully applied.';
            return response()->json([
                'status' => true,
                'message' => $message,
                'company_url' => $company_website,
            ], 200);
        } catch (\Exception $e) {

            $errorMessage = $e->getMessage();

            return response()->json([
                'status' => false,
                'message' => $errorMessage
            ], 500);
        }
    }
    // public function myJobApplications() {
    //     try {
    //         $jobApplications = JobApply::where('user_id', auth()->id())->with('job')->get()->map(function($item) {
    //             return ($item->job);
    //         });
    //         return response()->json([ 'status' => true,
    //         'data' => $jobApplications,
    //     ], 200);
    //     } catch (\Exception $e) {
    //         return response()->view('error.view', ['error' => $e->getMessage()], 500);
    //     }
    // }
    // public function getapplyjob(){
    //     return view('jobapply');
    // }
    public function myJobApplications()
    {
        try {
            $jobApplications = JobApply::where('user_id', auth()->id())->with('job', 'company')->get();
            return view('jobapply', [
                'jobApplications' => $jobApplications
            ]);
        } catch (\Exception $e) {
            return response()->view('error.view', ['error' => $e->getMessage()], 500);
        }
    }


    public function saveJob(Request $request)
    {
        try {
            $id = $request->id;

            $job = Job::find($id);

            if ($job == null) {
                $message = 'No Job Found.';
                return response()->json([
                    'status' => false,
                    'message' => $message,
                ], 404);
            }
            $company_id = $job->company_id;
            $count = SavedJob::where([
                'user_id' => Auth::user()->id,
                'job_id' => $id,
                'company_id' =>  $company_id,
            ])->count();

            if ($count > 0) {
                $message = 'You already saved this job.';
                return response()->json([
                    'status' => false,
                    'message' => $message,
                ], 500);
            }
            $savedJob = new SavedJob;
            $savedJob->job_id = $id;
            $savedJob->user_id = auth()->id();
            $savedJob->company_id = $company_id;
            $savedJob->save();
            $message = 'You successfully saved this job.';
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $savedJob
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function savedJobsdetail()
    {
        try {
            $savedJobs = SavedJob::where([
                'user_id' => auth()->id()
            ])->with('job', 'company')->get();
            //  dd($savedJobs);
            return view('savejob', [
                'savedJobs' => $savedJobs
            ]);
        } catch (\Exception $e) {
            return response()->view('error.view', ['error' => $e->getMessage()], 500);
        }
    }
    public function removeSavedJob(Request $request)
    {
        try {
            $savedJob = SavedJob::where([
                'id' => $request->id,
                'user_id' => auth()->id()
            ])->first();
            if ($savedJob == null) {
                return response()->json([
                    'status' => false,
                ], 404);
            }
            SavedJob::find($request->id)->delete();
            $message = 'You successfully removed this job.';
            return response()->json([
                'status' => true,
                'message' => $message
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while removing the job.'
            ], 500);
        }
    }
    //     public function removeAppliedJob($id){
    //         try {

    //             $jobApplication = JobApply::where('job_id', $id);

    //             //if() // check
    //             $jobApplication->where('user_id', auth()->id());


    //             $jobApplication= $jobApplication->first();


    //             if (!$jobApplication) {
    //                 return response()->json([
    //                     'status' => false,
    //                     'message' =>"Job application not found"
    //                 ], 404);
    //             }
    //             $jobApplication->delete();

    //             $message = 'You successfully removed this job.';
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => $message
    //             ], 200);

    //         } catch (\Exception $e) {

    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'An error occurred while removing the job.'
    //             ], 500);
    //         }
    // }
    public function removeAppliedJob(Request $request)
    {
        try {
            $jobApplication = JobApply::where(
                [
                    'id' => $request->id,
                    'user_id' => auth()->id()
                ]
            )->first();
            if ($jobApplication == null) {
                return response()->json([
                    'status' => false,
                ], 404);
            }
            JobApply::find($request->id)->delete();
            $message = 'You successfully removed this job.';
            return response()->json([
                'status' => true,
                'message' => $message
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while removing the job.'
            ], 500);
        }
    }
    public function detail(Request $request)
    {
        $params = ($request->input('params'));
        try {
            $originalJob = Job::find($params['id']);
            $duplicatedJob = $originalJob->replicate();
            $duplicatedJob->created_at = Carbon::now()->format('Y-m-d');
            // dd($params['type']);
            if ($params['type'] == 'Duplicate') {
                $duplicatedJob->post_status = 'Draft';
                $duplicatedJob->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Job duplicated successfully',
                    'duplicatedJob' => $duplicatedJob,
                ], 200);
            }
            if ($params['type'] == 'Post Job') {
                $user = User::where('id', $originalJob->user_id)->first();
                $post_allowed = Plan::where('id', $user->plan_id)->value('posts_allowed');
                $job_count = $originalJob->where('post_status', 'Published')->count();
                // && $user->subscription_status == 'active'
                if ($job_count <= $post_allowed  && $user->subscription_status == 'active') {
                    if ($originalJob->post_status == 'Published') {
                        return response()->json([
                            'status' => false,
                            'message' => 'You already posted this Job',
                        ], 406);
                    } else {
                        $originalJob->post_status = 'Published';
                        $originalJob->save();
                        return response()->json([
                            'status' => true,
                            'message' => 'Job Posted Successfully',
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => `You can't post more Jobs`
                    ], 403);
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function qualification($id)
    {
        try {
            $user = User::find($id);
            if ($user == null) {
                $message = 'No User Found.';
                return response()->json([
                    'status' => false,
                    'message' => $message,
                ], 404);
            }
            $qualifications = $user->qualifications;
            return response()->json([
                'status' => true,
                'data' => $qualifications,
            ]);
        } catch (\Exception $e) {

            return response()->view('error.view', ['error' => $e->getMessage()], 500);
        }
    }
    public function experience($id)
    {
        try {
            $user = User::find($id);
            if ($user == null) {
                $message = 'No User Found.';
                return response()->json([
                    'status' => false,
                    'message' => $message,
                ], 404);
            }
            $experience = $user->experience;
            return response()->json([
                'status' => true,
                'data' => $experience,
            ]);
        } catch (\Exception $e) {
            return response()->view('error.view', ['error' => $e->getMessage()], 500);
        }
    }
    public function getapplicants($id)
    {
        try {
            $job = Job::find($id);
            if ($job == null) {
                $message = 'No Job Found.';
                return response()->json([
                    'status' => false,
                    'message' => $message,
                ], 404);
            }
            $application = JobApply::where('job_id', $id)->with('user')->get()->map(function ($item) {
                return ($item->user);
            });
            return response()->json([
                'status' => true,
                'data' => $application,
            ], 200);
        } catch (\Exception $e) {
            return response()->view('error.view', ['error' => $e->getMessage()], 500);
        }
    }
}
