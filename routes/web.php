<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


// User routes
Route::get('/user', [UserController::class, 'index'])->middleware('auth')->name('userlist');
Route::get('/user/create', [UserController::class, 'create'])->middleware('auth')->name('user.create');
Route::post('/user', [UserController::class, 'store'])->middleware('auth')->name('user.store');
Route::get('/user/{id}', [UserController::class, 'show'])->middleware('auth')->name('user.show');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->middleware('auth')->name('user.edit');
Route::put('/user/{id}', [UserController::class, 'update'])->middleware('auth')->name('user.update');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->middleware('auth')->name('user.destroy');
Route::get('/users/data', [UserController::class, 'getData'])->name('user.data');

Route::middleware(['auth'])->group(function () {
    // List all cabinets
    Route::get('/cabinets', [CabinetController::class, 'index'])->name('cabinets.index');
    
    // Show cabinet details
    Route::get('/cabinets/{cabinet}', [CabinetController::class, 'show'])->name('cabinets.show');
    
    // Check-in routes
    Route::get('/cabinets/check-in/form', [CabinetController::class, 'showCheckInForm'])->name('cabinets.check-in.form');
    Route::post('/cabinets/check-in', [CabinetController::class, 'checkIn'])->name('cabinets.check-in');
    
    // Check-out routes
    Route::get('/cabinets/check-out/form', [CabinetController::class, 'showCheckOutForm'])->name('cabinets.check-out.form');
    Route::post('/cabinets/check-out', [CabinetController::class, 'checkOut'])->name('cabinets.check-out');
    
    // Transaction history
    Route::get('/cabinets/transactions/history', [CabinetController::class, 'transactions'])->name('cabinets.transactions');
});