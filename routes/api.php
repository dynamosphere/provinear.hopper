<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/reset-password', [AuthenticationController::class, 'resetPassword'])->name('reset-password');

});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthenticationController::class, 'user']);
    Route::get('/logout', [AuthenticationController::class, 'logout'])->name('auth.logout');
    Route::get('/email/verify/{id}/{hash}', [AuthenticationController::class, 'verifyEmail']
    )->middleware(['signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [AuthenticationController::class, 'resendVerificationEmail'])
    ->middleware(['throttle:6,1'])->name('verification.send');
});