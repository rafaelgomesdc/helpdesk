<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.auth');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| CADASTRO
|--------------------------------------------------------------------------
*/

Route::get('/cadastrar', [RegisterController::class, 'index'])
    ->name('register.form');

Route::post('/cadastrar', [RegisterController::class, 'store'])
    ->name('register');

/*
|--------------------------------------------------------------------------
| RESET PASSWORD
|--------------------------------------------------------------------------
*/

Route::get('/reset-password', [ResetPasswordController::class, 'index'])
    ->name('password.request');

Route::post('/reset-password', [ResetPasswordController::class, 'ajax'])
    ->name('password.ajax');

/*
|--------------------------------------------------------------------------
| ÁREA AUTENTICADA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categorias', CategoriaController::class)->except(['show']);
});
