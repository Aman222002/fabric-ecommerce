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



class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = auth()->user();

            $companyId = 0;

            if($user->hasRole('Company Admin')){
                $companyId =  $user->company ? $user->company->id : 0;
            }
            
            $jobs = Job::with("company");

            if($companyId != 0){
                $jobs->where('company_id', $companyId);
            }
            $jobs =   $jobs->get();

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
            $user = Auth::user();
            if (!$user->company) {
                return response()->json(['status' => false, 'message' => 'User does not have a company'], 422);
            }
           
            $company = $user->company;
            $input = $request->all();
            $job = Job::create([
                'user_id' => $user->id,
                'company_id' =>  $company->id,
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

    public function applyJob(Request $request) {
        try {
            $id = $request->id;
       
            $job = Job::where('id',$id)->first();
          
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
                ],500);
            }
            $application = new JobApply();
            $application->job_id = $id;
            $application->user_id = Auth::user()->id;
            $application->company_id = $company_id;
            $application->applied_date = now();
            $application->save();
           
            $company = Company::where('id',$company_id)->first();
        
            $mailData = [
                'company' => $company,
                'user' => Auth::user(),
                'job' => $job,
            ];
    
            Mail::to($company->company_email)->send(new JobNotificationEmail($mailData));
    
            $message = 'You have successfully applied.';
    
            $message = 'You have successfully applied.';
    
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $application
            ], 200);
        } catch (\Exception $e) {
            
            $errorMessage = $e->getMessage();
    
            return response()->json([
                'status' => false,
                'message' => $errorMessage
            ], 500); 
        }
    }
    public function myJobApplications() {
        try {
            $jobApplications = JobApply::where('user_id', auth()->id())->with('job')->get();
    
            return view('jobapply', [
                'jobApplications' => $jobApplications
            ]);
        } catch (\Exception $e) {
            return response()->view('error.view', ['error' => $e->getMessage()], 500);
        }
    }
    
   
    public function saveJob(Request $request) {
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
    
            $count = SavedJob::where([
                'user_id' => Auth::user()->id,
                'job_id' => $id
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
    public function savedJobsdetail(){
        try {
            $savedJobs = SavedJob::where([
                    'user_id' => auth()->id()
                ])->with('job')
                ->orderBy('created_at','DESC')->get();
            return view('savejob', [
                'savedJobs' => $savedJobs
            ]);
            
        } catch (\Exception $e) {
            return response()->view('error.view', ['error' => $e->getMessage()], 500);
        }
    }
    public function removeSavedJob(Request $request){
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


        public function removeAppliedJob(Request $request){
            try {
                $jobApplication = JobApply::where([
                    'id' => $request->id, 
                    'user_id' => auth()->id()]
                )->first();
                if ($jobApplication == null) {
                    return response()->json([
                        'status' => false,
                    ], 404);
                }
                JobApply ::find($request->id)->delete();
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
    public function detail($id) {
       
        try {
          
           
           
    
            $job = Job::find($id);
     
            if ($job == null) {
                $message = 'No Job Found.';
                return response()->json([
                    'status' => false,
                    'message' => $message,
                ], 404);
            }
          
            $application = JobApply::where('job_id', $id)->with('user','job')->get();
     
            return view('postdetail', ['application'=>$application]);
        } catch (\Exception $e) {
            
            return response()->view('error.view', ['error' => $e->getMessage()], 500);
        }
    }
    
   
}
