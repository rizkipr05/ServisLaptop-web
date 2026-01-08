<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Halaman Home
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Halaman Booking
Route::get('/booking', function () {
    return Inertia::render('Booking/Create');
})->name('booking.create');

// Halaman Tracking untuk pantau status perbaikan
Route::get('/tracking', function () {
    return Inertia::render('Tracking/Index');
})->name('tracking.index');
