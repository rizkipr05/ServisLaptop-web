<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BookingController;

// Halaman Utama
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Definisi Route Login & Register Manual 
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login')->middleware('guest');

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register')->middleware('guest');


// Group Route Khusus Member (Wajib Login)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard Standard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Menampilkan Form Booking
    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');

    // Memproses Data Booking
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
});


// Halaman Tracking (Bebas Akses/Public)
Route::get('/tracking', function () {
    return Inertia::render('Tracking/Index');
})->name('tracking.index');