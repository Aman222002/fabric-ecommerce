<?php

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


Route::put('/user', 'API\UsersController@putUpdateUser');
// Route::apiResource('products', ProductController::class);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('register','UserController@register');
// Route::post('login','UserController@login');
// Route::get('profile','UserController@getAuthenticatedUser');

// Route::middleware('auth:api')->get('/user', function(Request $request){
//     return $request->user();
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {
    Route::resource('users', App\Http\Controllers\Api\UserController::class);
});
// Route::get('users', [Api\UsersController::class, 'index']);
// Route::post('users', [Api\UsersController::class, 'store']);
// Route::get('users/{user}', [Api\UsersController::class, 'show']);
// Route::put('users/{user}', [Api\UsersController::class, 'update']);
// Route::delete('users/{user}', [Api\UsersController::class, 'destroy']);
