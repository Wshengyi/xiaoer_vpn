<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'home'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/subscription', [DashboardController::class, 'subscriptionLinks'])->name('subscription');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/plans', [AdminController::class, 'storePlan'])->name('admin.plans.store');
    Route::post('/admin/subscriptions', [AdminController::class, 'storeSubscription'])->name('admin.subscriptions.store');
    Route::post('/admin/subscriptions/{subscription}/reset-token', [AdminController::class, 'resetToken'])->name('admin.subscriptions.resetToken');
});
