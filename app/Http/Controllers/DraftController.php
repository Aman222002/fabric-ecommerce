<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use App\Models\JobType;

class DraftController extends Controller
{
    //
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            $companyId = session('company_id'); 
            
            $jobs = Job::with("company")->where('is_draft', 1);
            
            if($companyId){
                $jobs->where('company_id', $companyId);
            }
            
            $jobs = $jobs->get();
    
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
    public function draft($id, Request $request) {
        try {
            $originalJob = Job::find($id);
            if(!$originalJob) {
                return response()->json(['status' => false, 'message' => 'Job not found'], 404);
            }
            $originalJob->is_draft = 0;
            $originalJob->save();
            
            return response()->json([
                'status' => true,
                'message' => 'Job status updated successfully',
                'updatedJob' => $originalJob,
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
}
