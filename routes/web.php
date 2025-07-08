<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Front\WelcomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReservationController;
// 
// Route::view('/', 'welcome');
Route::view('/pusher', 'pusher');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::get('/',[WelcomeController::class,'index'])->name('welcome');

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


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/reservation/step1', [ReservationController::class, 'step1'])->name('reservation.step1');
Route::post('/reservation/step1', [ReservationController::class, 'postStep1']);
Route::get('/reservation/step2', [ReservationController::class, 'step2'])->name('reservation.step2');
Route::post('/reservation/step2', [ReservationController::class, 'postStep2']);


// Authentication Routes in breeze
require __DIR__.'/auth.php';