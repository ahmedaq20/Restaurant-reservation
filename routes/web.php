<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
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

     // --- Notification Routes (New) ---
    Route::prefix('notifications')->name('notifications.')->group(function () {
        // Route to view all notifications (if you create a dedicated page)
        Route::get('/', function () {
            // This will fetch all notifications for the authenticated admin
            // You might want to paginate them if there are many
            $notifications = auth()->user()->notifications()->latest()->paginate(20);
            return view('admin.notifications.index', compact('notifications'));
        })->name('index');

        // Mark all notifications as read
        Route::post('/mark-all-as-read', function (Request $request) {
            auth()->user()->unreadNotifications->markAsRead();
            return response()->json(['success' => true, 'message' => 'All notifications marked as read.']);
        })->name('mark-all-as-read');

        // Mark a single notification as read
        Route::post('/{id}/mark-as-read', function (Request $request, $id) {
            // Ensure the notification belongs to the authenticated user
            $notification = auth()->user()->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
                return response()->json(['success' => true, 'message' => 'Notification marked as read.']);
            }
            return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
        })->name('mark-as-read');

        // Archive (delete) a single notification
        Route::post('/{id}/archive', function (Request $request, $id) {
            $notification = auth()->user()->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->delete(); // This actually deletes it from the database
                return response()->json(['success' => true, 'message' => 'Notification archived.']);
            }
            return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
        })->name('archive');
    });
    // --- End Notification Routes ---


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