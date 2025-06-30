<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AdminAdminController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth','admin'])->name('admin.')->prefix('admin')->group(function () {
        Route::get('/admin',[AdminController::class,'index']);
    });

require __DIR__.'/auth.php';
