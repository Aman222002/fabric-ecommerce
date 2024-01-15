<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use App\Models\JobType;
use Illuminate\Http\Request;

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
        $categories = Category::orderBy('name','ASC')->where('status',1)->get();

        $jobTypes = JobType::orderBy('name','ASC')->where('status',1)->get();

        return view('postjob',[
            'categories' =>  $categories,
            'jobTypes' =>  $jobTypes,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validationRules = [
            'title' => 'required',
            'category_id' => 'required|exists:categories,id',
            'job_type_id' => 'required|exists:job_types,id',
            'vacancy' => 'required|integer',
            'salary' => 'nullable|string',
            'location' => 'required|string',
            'description' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'experience' => 'required|string',
            'company_name' => 'required|string',
            'company_location' => 'required|string',
            'company_website' => 'required|url',
        ];
        $request->validate($validationRules);
        try{
            $input = $request->all();
            Job::create([
                'title' => $input['title'],
                'category_id' => $input['category_id'],
                'job_type_id' => $input['job_type_id'],
                'vacancy' => $input['vacancy'],
                'salary' => $input['salary'],
                'location' => $input['location'],
                'description' => $input['description'],
                'qualifications' => $input['qualifications'],
                'experience' => $input['experience'],
                'company_name' => $input['company_name'],
                'company_location' => $input['company_location'],
                'company_website' => $input['company_website'],

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
