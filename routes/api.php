<?php

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;

Route::post('/auth/register', [AuthController::class, 'register']);

Route::get('/auth/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login']);

Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

//Public only for test
//Activity Log
Route::get('/activities', function(){
    return ActivityLog::all();
});

//Users
Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::patch('/user/{id}', [UserController::class, 'patch']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);
//Posts
Route::get('/posts/{status?}', [PostController::class, 'index']);
Route::get('/myposts/user/{id}', [PostController::class, 'indexUser']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::post('/posts', [PostController::class, 'store']);
Route::put('/post/{id}', [PostController::class, 'update']);
Route::patch('/post/{id}', [PostController::class, 'patch']);
Route::delete('/post/{id}', [PostController::class, 'destroy']);