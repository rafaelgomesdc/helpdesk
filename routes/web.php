<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ArtigoController;
use Illuminate\Support\Facades\Route;

// ROTAS PÚBLICAS (SOMENTE LOGIN)
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/autenticar', [UserController::class, 'autenticar'])->name('autenticar');

// ROTAS PROTEGIDAS (SÓ ACESSA SE ESTIVER LOGADO)
Route::middleware(['verificar.login', 'controle.acesso'])->group(function () {

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::resource('users', UserController::class);
    Route::resource('cargos', CargoController::class);
    Route::resource('setores', SetorController::class)->parameters([
        'setores' => 'setor'
    ]);

    // Base de Conhecimento
    Route::resource('categorias', CategoriaController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('artigos', ArtigoController::class);

    Route::get('/', function () {
        return redirect()->route('users.index');
    });

});
