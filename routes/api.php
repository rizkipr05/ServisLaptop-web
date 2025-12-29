<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\Admin\BookingController as AdminBookingController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});


// PUBLIC (customer)
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);

// ADMIN
Route::middleware(['auth:sanctum','role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::apiResource('services', AdminServiceController::class);
    });

// CUSTOMER (auth)
Route::middleware(['auth:sanctum','role:customer'])->group(function () {
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);
});

// TRACKING (public)
Route::get('/tracking/{bookingCode}', [BookingController::class, 'tracking']);

// ADMIN
Route::middleware(['auth:sanctum','role:admin'])->prefix('admin')->group(function () {
    Route::get('/bookings', [AdminBookingController::class, 'index']);
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show']);
    Route::patch('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm']);
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus']);
    Route::patch('/bookings/{booking}/price', [AdminBookingController::class, 'setPrice']);
});