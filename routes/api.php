<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/posts/{post}/like', [\App\Http\Controllers\PostController::class, 'like']);
    Route::apiResource('post', \App\Http\Controllers\PostController::class);

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::get('/users/{user}/posts', [\App\Http\Controllers\UserController::class, 'post']);
    Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'getName']);
    Route::get('/users/{user}/follow', [\App\Http\Controllers\UserController::class, 'follow']);
    Route::get('/feed', [\App\Http\Controllers\UserController::class, 'feed']);
});
