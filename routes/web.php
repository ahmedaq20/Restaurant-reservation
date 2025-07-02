<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TableController;

Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth','admin'])->name('admin.')->prefix('admin')->group(function () {
        Route::get('/dashboard',[AdminController::class,'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class)->names('categories');
        Route::resource('menus', MenuController::class)->names('menus');
        Route::resource('tables', TableController::class)->names('tables');
        Route::resource('reservations', ReservationController::class)->names('reservations');
    });

require __DIR__.'/auth.php';