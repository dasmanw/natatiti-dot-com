<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/**
 * @covers Web auth routes
 */
Route::middleware('web')->group(function () {
    /**
     * @covers Guest Routes
     */
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'create'])->name('login');
        Route::post('/auth', [AuthController::class, 'store'])->name('auth');
        Route::get('/forgot-password', [AuthController::class, 'passwordRequest'])->name('password.request');
        Route::post('/forgot-password', [AuthController::class, 'passwordEmail'])->name('password.email');
        Route::get('/reset-password/{token}/{email}', [AuthController::class, 'passwordReset'])->name('password.reset')->middleware('signed');
        Route::post('/reset-password/{token}/{email}', [AuthController::class, 'passwordStore'])->name('password.store');
    });

    /**
     * @covers Auth Routes
     */
    Route::middleware('auth:web')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
