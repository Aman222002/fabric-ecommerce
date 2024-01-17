<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
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
Route::group(["prefix" => "/admin"], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/users', [DashboardController::class, 'getUsers']);
    Route::group(["prefix" => "/user"], function () {
        Route::get('/index', [UserController::class, 'index']);
        Route::get('/edit/{id}', [UserController::class, 'edit']);
        Route::post('/store', [UserController::class, 'store']);
        Route::post('/update/{id}', [UserController::class, 'update']);
        Route::delete('/destroy/{id}', [UserController::class, 'destroy']);
    });
});
