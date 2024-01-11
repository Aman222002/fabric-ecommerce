<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
    return view('welcome');
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

Route::get('/Registration', function () {
    return view('Registration');
});

Route::get('/Login', function () {
    return view('Login');
});

Route::get('/Header', function () {
    return view('Header');
});

Route::get('/Footer', function () {
    return view('Footer');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(["prefix" => "/admin", "middleware" => "auth"], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
//users
//user/{id} function(Request $request, $id)
