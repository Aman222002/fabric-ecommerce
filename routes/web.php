<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyLoginController;
use App\Http\Controllers\LoginController;
use App\Models\Company;
use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\JobTypesController;

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


Route::get('/', function()
{
   return view('layouts.default');
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
// Route::get('/home', [function () {
//     return view('home');
// }]);

// Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'check'])->name('login');
Route::get('/registration', [RegistrationController::class, 'index']);
Route::post('/registration', [RegistrationController::class, 'store'])->name('registration');


Route::prefix('company')->group(function () {
    Route::get('/register', [CompanyController::class, 'index']);
    Route::post('/post', [CompanyController::class, 'store'])->name('companyregister');
    Route::post('/login', [CompanyController::class, 'check']);
});



Route::get('/post/jobs', [JobsController::class, 'index']);
Route::post('/post', [JobsController::class, 'store']);
Route::get('/post/edit/{id}', [JobsController::class,'edit']);
Route::post('/post/jobs/{id}', [JobsController::class, 'update']);
Route::post('/post/delete/{id}', [JobsController::class, 'destroy']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(["prefix" => "/admin", "middleware" => "auth"], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']); 
});
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/jobtypes', [JobTypesController::class, 'index']);


//users
//user/{id} function(Request $request, $id)