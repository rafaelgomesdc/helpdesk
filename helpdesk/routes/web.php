<?php

use App\Http\Controllers\ArtigoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PrioridadeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => auth()->check() ? redirect()->route('dashboard') : redirect()->route('login'));

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/cadastrar', [RegisterController::class, 'index'])->name('register.form');
Route::post('/cadastrar', [RegisterController::class, 'store'])->name('register');

Route::get('/reset-password', [ResetPasswordController::class, 'index'])->name('password.request');
Route::post('/reset-password', [ResetPasswordController::class, 'ajax'])->name('password.ajax');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Chamados (todos os perfis autenticados)
    Route::get('/chamados', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/chamados/novo', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/chamados', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/chamados/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/chamados/{ticket}/comentar', [TicketController::class, 'storeComentario'])->name('tickets.comentario.store');

    // Base de conhecimento (leitura para todos)
    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
    Route::get('/faqs/{faq}', [FaqController::class, 'show'])->name('faqs.show');
    Route::get('/artigos', [ArtigoController::class, 'index'])->name('artigos.index');
    Route::get('/artigos/{artigo}', [ArtigoController::class, 'show'])->name('artigos.show');

    // Técnico + Admin
    Route::middleware('profile:Admin,Técnico')->prefix('tecnico')->name('technician.')->group(function () {
        Route::get('/pendentes', [TechnicianController::class, 'pending'])->name('pending');
        Route::get('/em-atendimento', [TechnicianController::class, 'inProgress'])->name('in-progress');
        Route::post('/chamados/{ticket}/atribuir', [TechnicianController::class, 'assign'])->name('assign');
        Route::get('/chamados/{ticket}/solucao', [TechnicianController::class, 'solutionForm'])->name('solution');
        Route::post('/chamados/{ticket}/solucao', [TechnicianController::class, 'saveSolution'])->name('save-solution');
    });

    // Admin + Técnico: artigos
    Route::middleware('profile:Admin,Técnico')->group(function () {
        Route::get('/artigos/novo', [ArtigoController::class, 'create'])->name('artigos.create');
        Route::post('/artigos', [ArtigoController::class, 'store'])->name('artigos.store');
        Route::get('/artigos/{artigo}/editar', [ArtigoController::class, 'edit'])->name('artigos.edit');
        Route::put('/artigos/{artigo}', [ArtigoController::class, 'update'])->name('artigos.update');
    });

    // Admin
    Route::middleware('profile:Admin')->group(function () {
        Route::resource('categorias', CategoriaController::class)->except(['show']);
        Route::resource('prioridades', PrioridadeController::class)->except(['show']);
        Route::resource('faqs', FaqController::class)->except(['index', 'show']);
        Route::delete('/artigos/{artigo}', [ArtigoController::class, 'destroy'])->name('artigos.destroy');

        Route::post('usuarios/{usuario}/aprovar', [UsuarioController::class, 'aprovar'])->name('usuarios.aprovar');
        Route::post('usuarios/{usuario}/rejeitar', [UsuarioController::class, 'rejeitar'])->name('usuarios.rejeitar');
        Route::resource('usuarios', UsuarioController::class);
        Route::resource('setores', SetorController::class)->except(['show'])->parameters(['setores' => 'setor']);
        Route::resource('cargos', CargoController::class)->except(['show']);
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('permissions', PermissionController::class)->except(['show']);

        Route::get('/gerenciar-chamados', [TechnicianController::class, 'manage'])->name('technician.manage');
        Route::post('/gerenciar-chamados/{ticket}/status', [TechnicianController::class, 'updateStatus'])->name('technician.update-status');
    });
});
