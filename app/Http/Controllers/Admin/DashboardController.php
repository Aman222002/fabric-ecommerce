<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.dashboard');
    }
    public function plans()
    {
        //
        return view('admin.plans');
    }
    public function viewUsers()
    {
        //
        return view('admin.user');
    }
    public function viewProfile()
    {
        //
        return view('admin.profile');
    }
    public function viewCompanies()
    {
        //
        return view('admin.companies');
    }
    /**
     * function to get Plans
     */
    public function getplans()
    {
        try {
            $plans = Plan::with('features')->get()->map(function ($plan) {
                $features = $plan->features;
                if ($features) {
                    return [
                        'id' => $plan['id'],
                        'Name' => $plan['name'],
                        'search' => $features->Search,
                        'Mails' => $features->Mails,
                        'Validity' => $features->Validity,
                        'Post Job' => $features->{'Post Job'},
                        'Duration of Job-Post' => $features->{'Duration of Job-Post'},
                        'Number of Job-Post' => $features->{'Number of Job-Post'},
                        'Price' => '$' . $features->price,
                    ];
                } else {
                    return null;
                }
            });
            if ($plans) {
                return response()->json(['status' => true, 'data' => $plans], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Plans not Found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'messsage' => $e], 500);
        }
    }
    public function updatePlans(Request $request, $planId = 0)
    {
        try {
            $plan = Plan::find($planId);
            if ($plan) {
                $plan->update($request->all());
                return response()->json(['status' => true, 'message' => 'plan updated Successfully'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'messsage' => $e], 500);
        }
    }
    /**
     * function to view user who had buyed this plan
     */
    public function getDetails(Request $request)
    {
        // dd($request->planID);
        try {
            $users = User::where('plan_id', $request->planID)->where('subscription_status', 'active')->get();
            // dd($users);
            return response()->json(['status' => true, 'data' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    /**
     * funtion for admin logout
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['status' => true, 'message' => 'Logout Successfully'], 200);
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
