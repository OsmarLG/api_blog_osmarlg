<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use L5Swagger\Http\Controllers\SwaggerController;

Route::get('/', function () {
    return redirect(route('home'));
});

Route::get('/auth/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth/register', [AuthController::class, 'registerWeb'])->name('registerWeb');
Route::get('/auth/login', [AuthController::class, 'loginForm'])->name('loginForm');
Route::post('/auth/login', [AuthController::class, 'login'])->name('loginWeb');
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware([])->group(function () {
    Route::get('api/documentation', [SwaggerController::class, 'api'])->name('l5swagger.api');
});