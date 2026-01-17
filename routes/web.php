<?php

use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('product', function () {
    return 'products list';
})->middleware('admin');

Route::get('/admin', function () {
    return 'Admin Panel';
})->middleware(CheckAdmin::class);



require __DIR__ . '/auth.php';
