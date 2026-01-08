<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/booking', function () {
    return Inertia::render('booking/Create');
})->name('booking.create');
