<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Job;

class SearchjobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('companypost');
    }


    public function fetchData()
{
    try {
        // $jobs = Job::all();
        $user = auth()->user();

        $companyId = 0;

        if($user->hasRole('User')){
            $companyId =  $user->company ? $user->company->id : 0;
        }
        $jobs = Job::with("company");
        if($companyId != 0){
            $jobs->where('company_id', $companyId);
        }
        $jobs =   $jobs->get();
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
            $jobs->where('title', 'like', '%' . $request->input('jobTitle') . '%');
        }
        if ($request->has('location')) {
            $jobs->where('location', 'like', '%' . $request->input('location') . '%');
        }
       
        // if ($request->has('searchQuery')) {
        //     $searchQuery = $request->input('searchQuery');
        //     $jobs->whereRaw("MATCH(title, location) AGAINST(? IN BOOLEAN MODE)", [$searchQuery]);
        // }
        $jobs = $jobs->get();
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
    public function create()
    {
        //
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
