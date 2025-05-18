<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParcelController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;

// Redirect root URL to login page
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->group(function () {
    
    // Cabinet routes
    Route::get('/cabinet', [CabinetController::class, 'index'])->name('cabinet.index');
    Route::post('/cabinet/checkin', [CabinetController::class, 'checkin'])->name('cabinet.checkin');
    Route::post('/cabinet/checkin/{cabinet}', [CabinetController::class, 'checkinOne'])->name('cabinet.checkinOne');
    Route::post('/cabinet/checkout', [CabinetController::class, 'checkout'])->name('cabinet.checkout');
    Route::post('/cabinet/checkout/{cabinet}', [CabinetController::class, 'checkoutOne'])->name('cabinet.checkoutOne');
    Route::get('/cabinet/search', [CabinetController::class, 'search'])->name('cabinet.search');
    Route::get('/cabinet/userParcels', [CabinetController::class, 'userParcels'])->name('cabinet.userParcels');

    // Parcel routes
    Route::get('/parcels', [ParcelController::class, 'index'])->name('parcels.index');
    Route::get('/parcels/data', [ParcelController::class, 'getData'])->name('parcels.data');

    // User routes
    Route::get('/profile/edit', [UserController::class, 'editOwn'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateOwn'])->name('profile.update');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('userlist');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/users/data', [UserController::class, 'getData'])->name('user.data');
});
