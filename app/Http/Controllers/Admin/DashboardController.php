<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\Partner;
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
        return view('admin/blog');
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
            // $jobs = Job::all();
            return response()->json(['status' => true, 'data' => $blogs], 200);
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
}
