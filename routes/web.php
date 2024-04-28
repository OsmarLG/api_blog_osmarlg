<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/register', [AuthController::class, 'register'])->name('register');
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
