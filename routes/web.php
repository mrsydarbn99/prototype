<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');


// User routes
Route::get('/user', [UserController::class, 'index'])->middleware('auth')->name('userlist');
Route::get('/user/create', [UserController::class, 'create'])->middleware('auth')->name('user.create');
Route::post('/user', [UserController::class, 'store'])->middleware('auth')->name('user.store');
Route::get('/user/{id}', [UserController::class, 'show'])->middleware('auth')->name('user.show');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->middleware('auth')->name('user.edit');
Route::put('/user/{id}', [UserController::class, 'update'])->middleware('auth')->name('user.update');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->middleware('auth')->name('user.destroy');