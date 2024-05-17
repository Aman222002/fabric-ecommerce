<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\Partner;
use App\Models\Job;
use App\Models\Plan;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
     * function to return blog view
     */
    public function viewAddBlog()
    {
        return view('admin.blog');
    }
    /**
     * function to return jobs view
     */
    public function viewJobs()
    {
        return view('admin.jobs');
    }

    public function viewpartener()
    {
        return view('admin.partener');
    }
    /**
     * function to get all jobs
     */
    public function getAllJobs()
    {
        try {
            $publishedJobsQuery = Job::getTotalPublishedJobs();
            $publishedJobs = $publishedJobsQuery->with('company')->get();
            $recentJobs = $publishedJobsQuery->with('company')->latest()->take(5)->get();;
            $modifiedPublishedJobs = $publishedJobs->map(function ($job) {
                return [
                    'id' => $job->id,
                    'company_name' => $job->company->company_name,
                    'company_email' => $job->company->company_email,
                    'company_phone' => $job->company->phone_number,
                    'title' => $job->title,
                    'location' => $job->location,
                    'salary' => $job->salary,
                    'vacancy' => $job->vacancy,
                    'company_website' => $job->company_website,
                    // Include other company fields if needed
                ];
            });
            // $totalJobData = $publishedJobs->map(function ($job) {
            //     return [
            //         'Month' => $job->
            //     ];
            // });
            $recentJobs = $recentJobs->map(function ($job) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'location' => $job->location,
                    // Include other company fields if needed
                ];
            });
            Log::info('data' . json_encode($publishedJobs));
            $totalCount = $publishedJobs->count();
            return response()->json(['status' => true, 'data' => $modifiedPublishedJobs, 'recentJobs' => $recentJobs, 'totalCount' => $totalCount], 200);
        } catch (\Exception $e) {
            // Return error response if any exception occurs
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
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
                        'id' => $plan->id,
                        'Name' => $plan->name,
                        'search' => $features->Search,
                        'Mails' => $features->Mails,
                        'Validity' => $features->Validity,
                        'Post Job' => $features->{'Post Job'},
                        'Duration of Job-Post' => $features->{'Duration of Job-Post'},
                        'Number of Job-Post' => $features->{'Number of Job-Post'},
                        'Price' => '$' . $plan->price,
                    ];
                } else {
                    return null;
                }
            });

            if ($plans->isNotEmpty()) {
                return response()->json(['status' => true, 'data' => $plans], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Plans not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
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
            return response()->json(['status' => false, 'messsage' => $e->getMessage()], 500);
        }
    }
    /**
     * function to view user who had buyed this plan
     */
    public function getDetails(Request $request)
    {
        // dd($request->planID);
        try {
            $users = User::where('plan_id', $request->planID)->get();
            // dd($users);
            return response()->json(['status' => true, 'data' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    /**
     * function to get contact details on landing Page
     */
    public function viewContact()
    {
        try {
            $details = Setting::all();
            return response()->json(['status' => true, 'data' => $details], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    /**
     * function to get Partners Logo
     */
    public function viewPartners()
    {
        try {
            $details = Partner::all();
            return response()->json(['status' => true, 'data' => $details], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    /**
     * function to return view of all blogs
     */
    public function viewAllBlogs()
    {
        return view('admin/blogposts');
    }
    /**
     * function to view all blogs
     */
    public function fetchAllBlogs(Request $request)
    {
        try {
            $blog = BlogPost::select('id', 'title', 'status', 'created_at', 'published_by', 'content', 'featured_image');
            if ($request->type == 'Active') {
                $blog->where('status', $request->type);
            } else if ($request->type == 'Draft') {
                $blog->where('status', $request->type);
            } else if ($request->type == 'All') {
                $blog;
            }
            $blogs = $blog->get()->map(function ($blog) {
                if ($blog->featured_image) {
                    $blog->featured_image =  Storage::disk('public')->url('/assets/' . $blog->featured_image);
                }
                return $blog;
            });;
            $totalCount = $blog->count();
            // $jobs = Job::all();
            return response()->json(['status' => true, 'data' => $blogs, 'totalCount' => $totalCount], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
        // try {
        //     $blog = BlogPost::select('id', 'title', 'status', 'created_at', 'published_by');
        //     $response = [];

        //     if ($request->requireTotalCount) {
        //         $response['totalCount'] = $blog->count();
        //     }

        //     if (isset($request->take)) {
        //         $blog->skip($request->skip)->take($request->take);
        //     }

        //     if (isset($request->sort)) {
        //         $sort = json_decode($request->sort, true);
        //         if (count($sort)) {
        //             $blog->orderBy($sort[0]['selector'], ($sort[0]['desc'] ? 'DESC' : 'ASC'));
        //         }
        //     } else {
        //         $blog->orderBy('created_at', 'DESC');
        //     }

        //     if ($request->has('filter')) {
        //         $filters = json_decode($request->filter, true);
        //         if (count($filters)) {
        //             $filters = is_array($filters[0]) ? $filters[0] : $filters;
        //             $search = !blank($filters[2]) ? $filters[2] : false;
        //             if ($search) {
        //                 $blog->where('name', 'like', "%$search%");
        //             }
        //         }
        //     }
        //     $blogList = $blog->get();
        //     $response['data'] = $blogList;
        //     $totalCount = $blog->count();
        //     if ($blogList->isNotEmpty()) {
        //         return response()->json([
        //             'status' => true,
        //             'data' => $blogList,
        //             'totalCount' => $totalCount,
        //         ], 200);
        //     } else {
        //         $response = [
        //             'status' => false,
        //             'message' => 'No Product found',
        //         ];
        //         return response()->json($response, 404);
        //     }
        // } catch (\Exception $e) {
        //     Log::error($e->getMessage());
        //     return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        // }
        // $blogs = BlogPost::all();
        // return response()->json(['status' => true, 'data' => $blogs], 200);
    }
    /**
     * function to handle image upload in blogs 
     */
    public function uploadBlogImage(Request $request)
    {
        try {
            // $Blog = BlogPost::$image = $request->file('user_image');
            if ($request->hasFile('upload')) {
                $image = $request->file('upload');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/assets', $imageName);
                $url = Storage::disk('public')->url('/assets/' . $imageName);
            }
            return response()->json(['fileName' => $imageName, 'uploaded' => 1, 'url' => $url]);
        } catch (\Exception $e) {
            return response()->json(['status' => true, 'message' => $e], 500);
        }
    }
    /**
     * function to save blog post
     */
    public function storeBlog(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'htmlContent' => 'required|string'
            ]);
            // dd(Auth::user()->name);
            // dd($request->hasFile('featured_image'));
            if ($request->hasFile('featured_image')) {
                $image = $request->file('featured_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/assets', $imageName);
                // dd($imageName);
            }
            $blogPost = new BlogPost();
            $blogPost->title = $request->input('title');
            $blogPost->content = $request->input('htmlContent');
            $blogPost->status = 'active';
            $blogPost->published_by = Auth::user()->name;
            $blogPost->featured_image = $imageName;
            $blogPost->save();
            return response()->json(['status' => true, 'message' => 'Blog post saved successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * function to update Blog
     */
    public function updateBlog(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'htmlContent' => 'required|string'
            ]);
            if ($request->hasFile('featured_image')) {
                $image = $request->file('featured_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/assets', $imageName);
            }
            $blogPost = BlogPost::findOrFail($request->id);
            // Update the blog post fields
            $blogPost->title = $request->input('title');
            $blogPost->content = $request->input('htmlContent');
            $blogPost->featured_image = empty($imageName) ? $blogPost->featured_image : $imageName;
            $blogPost->save();
            return response()->json(['status' => true, 'message' => 'Blog post updated successfully'], 200);
            // dd($request->id);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    /**
     * function to delete blog
     */
    public function deleteBlog(Request $request)
    {
        try {
            $blogPost = BlogPost::findOrFail($request->id);
            $blogPost->delete();
            return response()->json(['status' => true, 'message' => 'Blog post deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    /**
     * function to draft Blog
     */
    public function draftBlog(Request $request)
    {
        $params = ($request->input('params'));
        try {
            $originalBlog = BlogPost::find($params['id']);
            $duplicatedBlog = $originalBlog->replicate();
            $duplicatedBlog->created_at = Carbon::now()->format('Y-m-d');
            // dd($params['type']);
            if ($params['type'] == 'Duplicate') {
                $duplicatedBlog->status = 'Draft';
                $duplicatedBlog->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Blog duplicated successfully',
                    'duplicatedBlog' => $duplicatedBlog,
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * function to post drafted Blog
     */
    public function postBlog(Request $request)
    {
        $params = ($request->input('params'));
        try {
            $originalBlog = BlogPost::find($params['id']);
            // dd($params['type']);
            if ($params['type'] == 'Post Blog') {
                if ($originalBlog->status == 'active') {
                    return response()->json([
                        'status' => false,
                        'message' => 'You already posted this Job',
                    ], 406);
                } else {
                    $originalBlog->status = 'active';
                    $originalBlog->save();
                    return response()->json([
                        'status' => true,
                        'message' => 'Job Posted Successfully',
                    ]);
                }
                // $originalBlog->status = 'active';
                // $originalBlog->save();
                // return response()->json([
                //     'status' => true,
                //     'message' => 'Blog duplicated successfully',
                //     'duplicatedBlog' => $originalBlog,
                // ], 200);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * funcion to get graph data
     */
    public function getGraphData()
    {
        try {
            $publishedJobs = Job::getTotalPublishedJobs()->get();
            // Log::info('data' . json_encode($publishedJobs));
            $jobCountsByMonth = [];
            foreach ($publishedJobs as $job) {
                $createdAt = Carbon::parse($job->created_at);
                $month = $createdAt->format('F');
                if (!isset($jobCountsByMonth[$month])) {
                    $jobCountsByMonth[$month] = 0;
                }
                $jobCountsByMonth[$month]++;
            }
            Log::info('new' . json_encode($jobCountsByMonth));
            $formattedData = [];
            foreach ($jobCountsByMonth as $month => $jobCount) {
                $formattedData[] = [
                    'Month' => $month,
                    'jobCount' => $jobCount,
                ];
            }
            return response()->json(['status' => true, 'data' => $formattedData], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
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
    {  //
    }

    public function fetchAllPartener(Request $request)
    {
        try {
            $blogs = Partner::select('id', 'partner_name as title', 'partner_status as status', 'partner_title as content', 'partner_logo as featured_image');
    
           
            $blogs = $blogs->get()->map(function ($blog) {
                if ($blog->featured_image) {
                    $blog->featured_image = Storage::disk('public')->url('/assets/' . $blog->featured_image);
                }
                return $blog;
            });
    
            $totalCount = $blogs->count();
    
            return response()->json(['status' => true, 'data' => $blogs, 'totalCount' => $totalCount], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function storePartner(Request $request)
    {
        
        try {
            $request->validate([
                'title' => 'required|string|max:255',
               
            ]);
            // dd(Auth::user()->name);
            // dd($request->hasFile('featured_image'));
            if ($request->hasFile('featured_image')) {
                $image = $request->file('featured_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/assets', $imageName);
                
            }
            $blogPost = new Partner();
            $blogPost->partner_name = $request->input('title');
            $blogPost->partner_title = $request->input('htmlContent');
            $blogPost->partner_logo = $imageName;

            $blogPost->save();
            return response()->json(['status' => true, 'message' => 'Partner saved successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function deletePartner(Request $request)
    {
        try {
            $blogPost = Partner::findOrFail($request->id);
            $blogPost->delete();
            return response()->json(['status' => true, 'message' => 'Partner deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    public function updatePartner(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'htmlContent' => 'required|string'
            ]);
            if ($request->hasFile('featured_image')) {
                $image = $request->file('featured_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/assets', $imageName);
            }
            $blogPost = Partner::findOrFail($request->id);
            // Update the blog post fields
            $blogPost->partner_name = $request->input('title');
            $blogPost->partner_title = $request->input('htmlContent');
            $blogPost->partner_logo = empty($imageName) ? $blogPost->partner_logo : $imageName;
            $blogPost->save();
            return response()->json(['status' => true, 'message' => 'Partner updated successfully'], 200);
            // dd($request->id);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    
}
