<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/cadastrar', [RegisterController::class, 'index'])->name('register.form');
Route::post('/cadastrar', [RegisterController::class, 'store'])->name('register');

Route::get('/reset-password', [ResetPasswordController::class, 'index'])->name('password.request');
Route::post('/reset-password', [ResetPasswordController::class, 'ajax'])->name('password.ajax');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categorias', CategoriaController::class)->except(['show']);

    Route::middleware('profile:Admin')->group(function () {
        Route::post('usuarios/{usuario}/aprovar', [UsuarioController::class, 'aprovar'])->name('usuarios.aprovar');
        Route::post('usuarios/{usuario}/rejeitar', [UsuarioController::class, 'rejeitar'])->name('usuarios.rejeitar');
        Route::resource('usuarios', UsuarioController::class);
        Route::resource('setores', SetorController::class)->except(['show'])->parameters(['setores' => 'setor']);
        Route::resource('cargos', CargoController::class)->except(['show']);
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('permissions', PermissionController::class)->except(['show']);
    });
});
