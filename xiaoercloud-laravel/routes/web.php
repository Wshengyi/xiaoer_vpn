<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
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

    Route::get('/checkout/{plan}', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/checkout/{plan}', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/plans', [AdminController::class, 'storePlan'])->name('admin.plans.store');
    Route::put('/admin/plans/{plan}', [AdminController::class, 'updatePlan'])->name('admin.plans.update');
    Route::delete('/admin/plans/{plan}', [AdminController::class, 'deletePlan'])->name('admin.plans.delete');

    Route::post('/admin/subscriptions', [AdminController::class, 'storeSubscription'])->name('admin.subscriptions.store');
    Route::put('/admin/subscriptions/{subscription}', [AdminController::class, 'updateSubscription'])->name('admin.subscriptions.update');
    Route::delete('/admin/subscriptions/{subscription}', [AdminController::class, 'deleteSubscription'])->name('admin.subscriptions.delete');
    Route::post('/admin/subscriptions/{subscription}/reset-token', [AdminController::class, 'resetToken'])->name('admin.subscriptions.resetToken');

    Route::put('/admin/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.updateStatus');
});
