<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('postjob');
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
    
            // Check if either categories or jobTypes is empty
            if ($categories->isEmpty() || $jobTypes->isEmpty()) {
                return response()->json(['message' => 'No categories or job types found', 'status' => 404], 404);
            }
    
            return response()->json([
                'categories' => $categories,
                'jobTypes' => $jobTypes,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving data', 'error' => $e->getMessage(), 'status' => 500], 500);
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
            Job::create([
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
                'message' => "posted Success"
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
