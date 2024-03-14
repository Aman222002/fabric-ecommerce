<?php

use App\Http\Controllers\API\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserAchievementController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserSkillController;
use App\Http\Controllers\UserExperienceController;
use App\Http\Controllers\AdditionalInformationController;
use App\Http\Controllers\QualificationsController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyLoginController;

use App\Models\Company;
use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\JobTypesController;
use App\Http\Controllers\SearchjobController;
use App\Http\Controllers\webhookHandler;
use App\Models\Job;
use App\Models\Skill;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('companypage');
});
Auth::routes();
Route::get('/header', function () {
    return view('header');
});
Route::get('/resume', function () {
    return view('resume');
});
Route::get('/userprofile', function () {
    return view('userprofile');
});
Route::post('/removedEducation/{educationId}', [ResumeController::class, 'destroyEducation']);
Route::post('/removedExperience/{experienceId}', [ResumeController::class, 'destroyExperience']);
Route::post('/removedAchievment/{achievmentId}', [ResumeController::class, 'destroyAchievment']);
Route::post('/submit', [ResumeController::class, 'store']);

Route::get('/my-profile', [ResumeController::class, 'getUserData']);
Route::get('/getprofile', [ResumeController::class, 'getProfile']);
Route::get('/user-skills', [UserSkillController::class, 'index']);
Route::post('/user-skills', [UserSkillController::class, 'store']);
Route::post('/users-achievments', [UserAchievementController::class, 'store']);
Route::post('/user-profile', [UserProfileController::class, 'store']);
Route::post('/work_experience', [UserExperienceController::class, 'store']);
Route::post('/user-address', [UserAddressController::class, 'store']);
Route::get('/getcountry', [UserAddressController::class, 'index']);
Route::post('/address', [UserAddressController::class, 'index']);
Route::post('/users-qualifications', [QualificationsController::class, 'store']);
Route::get('/skills', [SkillController::class, 'index']);
Route::get('/getuser', [LoginController::class, 'getUser']);


Route::get('/header', function () {
    return view('Header');
});


Route::get('/footer', function () {
    return view('Footer');
});
Route::get('/job', function () {
    return view('Job');
});
// Route::get('/companyregister', function () {
//     return view('companyregister');
// });
Route::get('/product', function () {
    return view('product');
});
Route::get('/cart', function () {
    return view('cart');
});

Route::get('/postjob', function () {
    return view('postjob');
});
Route::get('/posted-jobs', function () {
    return view('jobcrud');
});
Route::get('/draft', function () {
    return view('draftjob');
});
Route::get('/findcv', function () {
    return view('findcv');
});

// Route::get('/add-user', function () {
//     return view('user');
// });



Route::get('/jobs-detail/{category?}/{title?}/{location?}', [SearchjobController::class, 'index']);
Route::get('/company/post', [SearchjobController::class, 'fetchData']);
Route::get('/search-jobs', [SearchjobController::class, 'searchJobs']);
// Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index']);
Route::get('/forget/password', [ForgotPasswordController::class, 'forgetPassword']);
Route::post('/get/forget/password/link', [ForgotPasswordController::class, 'getLink']);
Route::get('reset/password/{user_id}/{token}', [ForgotPasswordController::class, 'showResetPasswordForm']);
Route::post('/reset/new/password/', [ForgotPasswordController::class, 'updatePassword']);
Route::post('/login', [LoginController::class, 'check'])->name('login');
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/resume', [CvController::class, 'index']);
Route::post('/resume', [CvController::class, 'submitForm'])->name('resume');
Route::get('/registration', [RegistrationController::class, 'index']);
Route::post('/registration', [RegistrationController::class, 'store'])->name('registration');
Route::prefix('company')->group(function () {
    Route::get('/register/{id?}/{name?}/{email?}/{phone?}/{company?}/{permission?}', [CompanyController::class, 'index']);
    Route::post('/post/{permission?}', [CompanyController::class, 'store'])->name('companyregister');
    Route::post('/login', [CompanyController::class, 'check']);
    Route::get('/names/{email?}', [CompanyController::class, 'getCompanyNames']);
    Route::get('/buy/plans/view/{id?}', [CompanyController::class, 'buyplansview']);
    Route::post('/buy/plan', [CompanyController::class, 'buyplan']);
    Route::get('/logout', [CompanyController::class, 'logout']);
});
Route::get('complete/redirect/flow/{userId}/{planId}/{session}', [CompanyController::class, 'completeRedirectFlow']);
Route::get('/create/mendate/form/{token}', [CompanyController::class, 'showForm']);
Route::post('/submit/mandate/form', [CompanyController::class, 'submitForm']);
Route::get('/user/data', [CompanyController::class, 'userdata']);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/post/jobs/{type?}', [JobsController::class, 'index']);
    Route::post('/post', [JobsController::class, 'store']);
    Route::get('/post/edit/{id}', [JobsController::class, 'edit']);
    Route::post('/post/jobs/{id}', [JobsController::class, 'update']);
    Route::delete('/post/delete/{id}', [JobsController::class, 'destroy']);
    Route::post('/apply-job/{id}', [JobsController::class, 'applyJob']);
    Route::get('/job-apply', [JobsController::class, 'myJobApplications']);
    // Route::get('/get/job-apply', [JobsController::class, 'myJobApplications']);
    Route::post('/save-job/{id}', [JobsController::class, 'saveJob']);
    Route::get('/savedjobs', [JobsController::class, 'savedJobsdetail']);
    Route::post('/removesavedjobs/{id}', [JobsController::class, 'removeSavedJob']);
    Route::post('/remove-applied-jobs/{id}', [JobsController::class, 'removeAppliedJob']);
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/get/plans', [DashboardController::class, 'getplans']);
//Admin Routes;
Route::group(["prefix" => "/admin"], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/logout', [DashboardController::class, 'logout']);
    Route::get('/profile', [DashboardController::class, 'viewProfile']);
    Route::get('/profile/getProfile', [UserController::class, 'getProfile']);
    Route::get('/users', [DashboardController::class, 'viewUsers']);
    Route::get('/companies', [DashboardController::class, 'viewCompanies']);
    Route::get('/plans', [DashboardController::class, 'plans']);
    Route::post('/update/plans/{planID?}', [DashboardController::class, 'updateplans']);
    Route::get('/company/plan/{planID?}', [DashboardController::class, 'getDetails']);

    Route::group(["prefix" => "/user"], function () {
        Route::get('/index', [UserController::class, 'index']);
        Route::get('/edit/{id}', [UserController::class, 'edit']);
        Route::post('/store/{permission?}', [UserController::class, 'store']);
        Route::post('/addnewuser', [UserController::class, 'addnewuser']);
        Route::post('/update/{id}', [UserController::class, 'update']);
        Route::post('/update-profile/{id}', [UserController::class, 'updateProfile']);
        Route::post('/update-password', [UserController::class, 'updatePassword']);
        Route::delete('/destroy/{id}', [UserController::class, 'destroy']);
    });
    Route::group(["prefix" => "/company"], function () {
        Route::get('/address/{addressId?}', [CompanyController::class, 'getAddress']);
        Route::post('/address/update/{addressId?}', [CompanyController::class, 'updateAddress']);
        Route::get('/representative/{userId?}', [CompanyController::class, 'findRepresentative']);
        Route::get('/getCompanies', [CompanyController::class, 'getCompanies']);
        Route::post('/store', [CompanyController::class, 'store']);
        Route::post('/update/{id}', [CompanyController::class, 'update']);
        Route::delete('/destroy/{id}', [CompanyController::class, 'destroy']);
    });
});
Route::get('/get/comapny-admin', [CompanyController::class, 'getCompanyAdmin']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/jobtypes', [JobTypesController::class, 'index']);
Route::get('/skill', [SkillController::class, 'index']);
Route::get('/permission', [SkillController::class, 'permission']);
Route::prefix('company')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::get('/list', [ProfileController::class, 'show']);
    Route::post('/update', [ProfileController::class, 'update']);
    Route::post('/updateaddress', [ProfileController::class, 'updateaddress']);
    Route::post('/updatedescription', [ProfileController::class, 'updatedescription']);
});
// Route::get('/jobs/applicants', [JobsController::class, 'getapplicants']);
Route::post('/jobs/draft/{id?}/{type?}', [JobsController::class, 'detail']);
Route::get('/jobs/qualification/{id}', [JobsController::class, 'qualification']);
Route::get('/jobs/experience/{id}', [JobsController::class, 'experience']);
Route::get('/jobs/application/{id}', [JobsController::class,'getapplicants']);

Route::get('/generate-pdf', [PdfController::class, 'download']);

Route::post('/update-status',[UserController::class,'updatestatus']);
Route::get('/draft/jobs', [DraftController::class, 'index']);
Route::get('/post/edit/{id}', [DraftController::class, 'edit']);
Route::post('/post/jobs/{id}', [DraftController::class, 'update']);
Route::delete('/post/delete/{id}', [DraftController::class, 'destroy']);
Route::post('/draftjobs/{id}', [DraftController::class, 'draft']);



Route::get('/add-user', [CompanyController::class, 'adduser']);
Route::get('/fetch-user/{type?}', [CompanyController::class, 'fetchuser']);
Route::get('/accepted/{id}/{name}/{company}/{email}/{phone}/{permission}', [UserController::class, 'accept']);
Route::get('/reject/{id}', [UserController::class, 'reject']);
Route::get('/users', [CompanyController::class, 'users']);
Route::get('/find/plan', [CompanyController::class, 'fetchPlan']);
Route::get('/get/all/plans', [CompanyController::class, 'getAllPlans']);
Route::get('/company/plan', [CompanyController::class, 'showCompanyPlan']);
Route::get('/cancel/upgrade', [CompanyController::class, 'cancelUpgradeRequest']);


//users
//user/{id} function(Request $request, $id)