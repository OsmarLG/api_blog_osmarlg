<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::patch('/users/{id}', [UserController::class, 'patch']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);
Route::middleware('auth:sanctum')->group(function () {

    //Auth Logout
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

    //Posts
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/post/{id}', [PostController::class, 'update']);
    Route::patch('/post/{id}', [PostController::class, 'patch']);
    Route::delete('/post/{id}', [PostController::class, 'destroy']);
});

//Public

Route::get('/posts', [PostController::class, 'index']);
Route::get('/post/{id}', [PostController::class, 'show']);
