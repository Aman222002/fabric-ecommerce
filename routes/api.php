<?php

use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\Api\UserController;
use GuzzleHttp\Middleware;
// use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route::apiResource('products', ProductController::class);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/userlogin', [UserController::class, 'login']);

Route::group(['middleware' =>'auth:api'],function(){
    Route::get('/my-profile', [UserController::class, 'getUserData']);
   
    Route::post('/post', [UserController::class, 'store']);
    Route::post('/post/jobs/{id}', [UserController::class, 'update']);
    Route::delete('/post/delete/{id}', [UserController::class, 'destroy']);
});

