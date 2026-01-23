<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Auth as MiddlewareAuth;
use App\Http\Middleware\CheckAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use PHPUnit\Metadata\Group;

// Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

// Route::get('product', function () {
//     return 'products list';
// })->middleware('admin');

// Route::get('/admin', function () {
//     return 'Admin Panel';
// })->middleware(CheckAdmin::class);


// Route::get('/api', [ApiController::class, 'check']);
// Route::get('/api/verify', [ApiController::class, 'verify']);
// Volt::route('/admin/students', 'admin.students.index')->name('admin.students');
// Volt::route('/admin/school-classes', 'admin.school_classes.index')->name('admin.school_classes');
// Volt::route('/admin/school-classes', 'todolist')->name('admin.school_classes');
// Volt::route('/counter', 'counter');
// require __DIR__ . '/auth.php';


Route::get('api/login', [LoginController::class, 'login'])->name('login');
Route::get('api/register', [LoginController::class, 'register'])->name('register');


Route::get('login', [LoginController::class, 'loginPage'])->name('loginPage');

Route::middleware([MiddlewareAuth::class])->group(function () {
    Volt::route('dashboard', 'dashboard')->name('dashboard');
});

