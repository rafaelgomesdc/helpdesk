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
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PrioridadeController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ArtigoController;
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
        Route::resource('prioridades', PrioridadeController::class);
    });

    // Relatórios (admin e técnico)
    Route::get('/relatorios/tempo-medio', [RelatorioController::class, 'tempoMedio'])
         ->name('relatorios.tempo-medio');

    // Base de Conhecimento (todos autenticados)
    Route::resource('faqs', FaqController::class);
    Route::resource('artigos', ArtigoController::class);
});

//Abertura e comunicação de chamados (Dupla 2)
Route::middleware(['auth'])->group(function () {
    Route::get('/meus-chamados', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/chamados/novo', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/chamados/salvar', [TicketController::class, 'store'])->name('tickets.store');
    
    Route::get('/ticketEspecifico/{ticket_id}', [TicketController::class, 'viewChamado'])->name('tickets.show');
    //Route::get('/chamados/{id}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/chamados/{id}/comentar', [TicketController::class, 'storeComentario'])->name('tickets.comentario.store');
});