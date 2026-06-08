<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\PrioridadeController;
use App\Http\Controllers\RelatorioController;

// Autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'autenticar'])->name('autenticar');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas (requer sessão ativa)
Route::middleware('auth.session')->group(function () {

    // Usuários
    Route::resource('users', UserController::class);

    // Cargos (somente admin)
    Route::resource('cargos', CargoController::class);

    // Setores (somente admin)
    Route::resource('setores', SetorController::class);

    // Prioridades (somente admin)
    Route::resource('prioridades', PrioridadeController::class);

    // Relatórios (admin e técnico)
    Route::get('/relatorios/tempo-medio', [RelatorioController::class, 'tempoMedio'])
         ->name('relatorios.tempo-medio');
});
