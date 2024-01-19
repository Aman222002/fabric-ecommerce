<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $jobs = Job::all();
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
            }else {
        
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
            'companyname' => 'required|string',
            'companylocation' => 'required|string',
            'companywebsite' => 'required|url',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 422);
        }
        try{
            $input = $request->all();
            $job= Job::create([
                'title' => $input['title'],
                'category_id' => $input['category'],
                'job_type_id' => $input['jobType'],
                'vacancy' => $input['vacancy'],
                'salary' => $input['salary'],
                'location' => $input['location'],
                'description' => $input['description'],
                'qualifications' => $input['qualifications'],
                'experience' => $input['experience'],
                'company_name' => $input['companyname'],
                'company_location' => $input['companylocation'],
                'company_website' => $input['companywebsite'],
            ]);  
            return response()->json([
                'status' => true,
                'message' => 'Posted successfully',
                'data' => $job,
            ], 201);

        } catch(\Exception $e){
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
}

