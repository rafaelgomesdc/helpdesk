<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'loginTela'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.entrar');
Route::post('/login-teste', [AuthController::class, 'loginTeste'])->name('login.teste');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::resource('roles', RoleController::class);

Route::get('/dashboard', function () {
    return 'Você está logado!';
})->middleware('auth');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return 'Área do admin';
    });
});

use App\Http\Controllers\PermissionController;

Route::resource('permissions', PermissionController::class);