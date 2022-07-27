<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\LogInController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('login', [LogInController::class, 'login']);
Route::post('register', [LogInController::class, 'register']);
Route::post('logout', [LogInController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'role','middleware' => 'auth:sanctum'], function() {
    Route::get('/', [RoleController::class,'index']);
    Route::post('add', [RoleController::class,'create']);
    Route::get('edit/{id}', [RoleController::class,'edit']);
    //Route::get('rolename/{id}', [RoleController::class,'rolename']);
    Route::post('update/{id}', [RoleController::class,'update']);
    Route::delete('delete/{id}', [RoleController::class,'delete']);
});
Route::group(['prefix' => 'user','middleware' => 'auth:sanctum'], function() {
    Route::get('/', [UserController::class,'index']);
    Route::post('add', [UserController::class, 'add']);
    Route::get('edit/{id}', [UserController::class,'edit']);
    Route::post('update/{id}', [UserController::class,'update']);
    Route::delete('delete/{id}', [UserController::class,'delete']);
});
/*
Route::group(['prefix' => 'posts','middleware' => 'auth:sanctum'], function() {
    Route::get('/', [PostsController::class,'index']);
    Route::post('add', [PostsController::class,'add']);
    Route::post('update/{id}', [PostsController::class,'update']);
    Route::get('edit/{id}', [PostsController::class,'edit']);
    Route::delete('delete/{id}', [PostsController::class,'delete']);
});
*/
