<?php

use Illuminate\Support\Facades\Route;
use JobMetric\Authio\Http\Controllers\AuthController;
use JobMetric\Panelio\Facades\Middleware;

/*
|--------------------------------------------------------------------------
| Laravel Authio Routes
|--------------------------------------------------------------------------
|
| All Route in Laravel Authio package
*/

// authio
Route::prefix('auth')->name('auth.')->namespace('JobMetric\Authio\Http\Controllers')->group(function () {
    Route::middleware(Middleware::getMiddlewares())->group(function () {
        Route::get('/', [AuthController::class, 'index'])->name('index');
        Route::post('request', [AuthController::class, 'request'])->name('request');
        Route::post('otp', [AuthController::class, 'loginOtp'])->name('otp');
        Route::post('resend', [AuthController::class, 'resendOtp'])->name('resend');
        Route::post('password', [AuthController::class, 'loginPassword'])->name('password');
    });
});
