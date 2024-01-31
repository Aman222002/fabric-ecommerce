<?php

use App\Http\Controllers\API\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserAchievementController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserSkillController;
use App\Http\Controllers\UserExperienceController;
use App\Http\Controllers\AdditionalInformationController;
use App\Http\Controllers\QualificationsController;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyLoginController;

use App\Models\Company;
use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\JobTypesController;
use App\Http\Controllers\SearchjobController;

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
// Route::get('{any}', function () {
//     return view('app');
// })->where('any', '.*');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//     // Our resource routes
//     Route::resource('roles', RoleController::class);
//     Route::resource('users', UserController::class);
//     Route::resource('products', ProductController::class);
// });
Auth::routes();
Route::get('/header', function () {
    return view('header');
});
Route::get('/resume', function () {
    return view('resume');
});
Route::get('/user-skills', [UserSkillController::class, 'index']);
Route::post('/user-skills', [UserSkillController::class, 'store']);
Route::post('/users-achievments', [UserAchievementController::class, 'store']);
Route::post('/user-profile', [UserProfileController::class, 'store']);
Route::post('/work_experience', [UserExperienceController::class, 'store']);
Route::post('/user-address', [UserAddressController::class, 'store']);
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

Route::get('/postjob', function () {
    return view('postjob');
});
Route::get('/crud', function () {
    return view('jobcrud');
});
Route::get('/findcv', function () {
    return view('findcv');
});

Route::get('/companypost', [SearchjobController::class, 'index']);
Route::get('/company/post', [SearchjobController::class, 'fetchData']);
Route::get('/search-jobs', [SearchjobController::class, 'searchJobs']);




// Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'check'])->name('login');
Route::get('/resume', [CvController::class, 'index']);
Route::post('/resume', [CvController::class, 'submitForm'])->name('resume');
Route::get('/registration', [RegistrationController::class, 'index']);
Route::post('/registration', [RegistrationController::class, 'store'])->name('registration');
Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::prefix('company')->group(function () {
    Route::get('/register', [CompanyController::class, 'index']);
    Route::post('/post', [CompanyController::class, 'store'])->name('companyregister');
    Route::post('/login', [CompanyController::class, 'check']);
   
});




Route::group(['middleware' => 'auth'],function(){
Route::get('/post/jobs', [JobsController::class, 'index']);
Route::post('/post', [JobsController::class, 'store']);
Route::get('/post/edit/{id}', [JobsController::class, 'edit']);
Route::post('/post/jobs/{id}', [JobsController::class, 'update']);
Route::post('/post/delete/{id}', [JobsController::class, 'destroy']);
Route::post('/apply-job/{id}', [JobsController::class, 'applyJob']);

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(["prefix" => "/admin", "middleware" => "auth"], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/jobtypes', [JobTypesController::class, 'index']);
Route::get('/skill', [SkillController::class, 'index']);



Route::prefix('company')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::get('/list', [ProfileController::class, 'show']);
    Route::post('/update', [ProfileController::class, 'update']);
});




//users
//user/{id} function(Request $request, $id)