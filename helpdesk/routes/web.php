<?php

// =============================================================================
//  ROTAS DA APLICAÇÃO — HELPDESK
//
//  Organização por dupla responsável:
//  ┌──────────────────────────────────────────────────────────────────────────┐
//  │  Dupla 1 — Vitória e Camila   │  Usuários e Autenticação                │
//  │  Dupla 2 — Gustavo e Rafael   │  Abertura e Comunicação                 │
//  │  Dupla 3 — Paulo e Vitor      │  Gerenciamento e Painel Técnico         │
//  │  Dupla 4 — Gabriel e Murilo   │  Categorias, Prioridades, Dashboard     │
//  └──────────────────────────────────────────────────────────────────────────┘
// =============================================================================

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

// -----------------------------------------------------------------------------
//  ROTA RAIZ — Redireciona para dashboard ou login conforme autenticação
// -----------------------------------------------------------------------------
Route::get('/', fn () => auth()->check() ? redirect()->route('dashboard') : redirect()->route('login'));

// =============================================================================
//  DUPLA 1 — VITÓRIA E CAMILA
//  Autenticação: Login, Cadastro e Recuperação de Senha
// =============================================================================

// Login e logout
Route::get('/login',  [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.auth');
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

// Auto-cadastro de novos usuários (aguardam aprovação do admin)
Route::get('/cadastrar',  [RegisterController::class, 'index'])->name('register.form');
Route::post('/cadastrar', [RegisterController::class, 'store'])->name('register');

// Recuperação de senha por pergunta de segurança
Route::get('/reset-password',  [ResetPasswordController::class, 'index'])->name('password.request');
Route::post('/reset-password', [ResetPasswordController::class, 'ajax'])->name('password.ajax');

// =============================================================================
//  ROTAS AUTENTICADAS (requer login ativo)
// =============================================================================
Route::middleware('auth')->group(function () {

    // =========================================================================
    //  DUPLA 4 — GABRIEL E MURILO
    //  Dashboard: painel de indicadores e exportação de relatório
    // =========================================================================
    Route::get('/dashboard',            [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/perfil',    [DashboardController::class, 'updateProfile'])->name('dashboard.update-profile');
    Route::get('/dashboard/export-csv', [DashboardController::class, 'exportCsv'])->name('dashboard.export-csv');

    // =========================================================================
    //  DUPLA 2 — GUSTAVO E RAFAEL
    //  Chamados: abertura, visualização, comentários e exportação
    //  Disponível para todos os perfis autenticados
    // =========================================================================
    Route::get('/chamados',                     [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/chamados/export-csv',          [TicketController::class, 'exportCsv'])->name('tickets.export-csv');
    Route::get('/chamados/novo',                [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/chamados',                    [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/chamados/{ticket}',            [TicketController::class, 'show'])->whereNumber('ticket')->name('tickets.show');
    Route::post('/chamados/{ticket}/comentar',  [TicketController::class, 'storeComentario'])->whereNumber('ticket')->name('tickets.comentario.store');

    // =========================================================================
    //  DUPLA 2 — GUSTAVO E RAFAEL
    //  Base de Conhecimento: FAQs e Artigos (leitura para todos)
    // =========================================================================
    Route::get('/faqs',          [FaqController::class,    'index'])->name('faqs.index');
    Route::get('/faqs/{faq}',    [FaqController::class,    'show'])->whereNumber('faq')->name('faqs.show');
    Route::get('/artigos',       [ArtigoController::class, 'index'])->name('artigos.index');
    Route::get('/artigos/{artigo}', [ArtigoController::class, 'show'])->whereNumber('artigo')->name('artigos.show');

    // =========================================================================
    //  DUPLA 3 — PAULO E VITOR
    //  Painel Técnico: atendimento e resolução de chamados (Técnico + Admin)
    // =========================================================================
    Route::middleware('profile:Admin,Técnico')->prefix('tecnico')->name('technician.')->group(function () {
        Route::get('/pendentes',                        [TechnicianController::class, 'pending'])->name('pending');
        Route::get('/em-atendimento',                   [TechnicianController::class, 'inProgress'])->name('in-progress');
        Route::post('/chamados/{ticket}/atribuir',      [TechnicianController::class, 'assign'])->whereNumber('ticket')->name('assign');
        Route::get('/chamados/{ticket}/solucao',        [TechnicianController::class, 'solutionForm'])->whereNumber('ticket')->name('solution');
        Route::post('/chamados/{ticket}/solucao',       [TechnicianController::class, 'saveSolution'])->whereNumber('ticket')->name('save-solution');
    });

    // =========================================================================
    //  DUPLA 2 — GUSTAVO E RAFAEL
    //  Gestão de Artigos: criação e edição (Técnico + Admin)
    // =========================================================================
    Route::middleware('profile:Admin,Técnico')->group(function () {
        Route::get('/artigos/novo',              [ArtigoController::class, 'create'])->name('artigos.create');
        Route::post('/artigos',                  [ArtigoController::class, 'store'])->name('artigos.store');
        Route::get('/artigos/{artigo}/editar',   [ArtigoController::class, 'edit'])->name('artigos.edit');
        Route::put('/artigos/{artigo}',          [ArtigoController::class, 'update'])->name('artigos.update');
    });

    // =========================================================================
    //  ROTAS EXCLUSIVAS DO ADMINISTRADOR
    // =========================================================================
    Route::middleware('profile:Admin')->group(function () {

        // ---------------------------------------------------------------------
        //  DUPLA 4 — GABRIEL E MURILO
        //  Categorias e Prioridades dos chamados
        // ---------------------------------------------------------------------
        Route::resource('categorias',  CategoriaController::class)->except(['show']);
        Route::resource('prioridades', PrioridadeController::class)->except(['show']);

        // ---------------------------------------------------------------------
        //  DUPLA 2 — GUSTAVO E RAFAEL
        //  FAQs e exclusão de artigos (somente Admin)
        // ---------------------------------------------------------------------
        Route::resource('faqs', FaqController::class)->except(['index', 'show']);
        Route::delete('/artigos/{artigo}', [ArtigoController::class, 'destroy'])->name('artigos.destroy');

        // ---------------------------------------------------------------------
        //  DUPLA 1 — VITÓRIA E CAMILA
        //  Gerenciamento completo de usuários (aprovação, edição, exclusão)
        // ---------------------------------------------------------------------
        Route::post('usuarios/{usuario}/aprovar',  [UsuarioController::class, 'aprovar'])->whereNumber('usuario')->name('usuarios.aprovar');
        Route::post('usuarios/{usuario}/rejeitar', [UsuarioController::class, 'rejeitar'])->whereNumber('usuario')->name('usuarios.rejeitar');
        Route::resource('usuarios', UsuarioController::class);

        // ---------------------------------------------------------------------
        //  DUPLA 3 — PAULO E VITOR
        //  Setores, Cargos e gerenciamento geral de chamados pelo admin
        // ---------------------------------------------------------------------
        Route::resource('setores', SetorController::class)->except(['show'])->parameters(['setores' => 'setor']);
        Route::resource('cargos',  CargoController::class)->except(['show']);

        Route::get('/gerenciar-chamados',                    [TechnicianController::class, 'manage'])->name('technician.manage');
        Route::post('/gerenciar-chamados/{ticket}/status',   [TechnicianController::class, 'updateStatus'])->whereNumber('ticket')->name('technician.update-status');
        Route::post('/gerenciar-chamados/{ticket}/tecnico', [TechnicianController::class, 'updateTechnician'])->whereNumber('ticket')->name('technician.update-technician');

        // ---------------------------------------------------------------------
        //  DUPLA 4 — GABRIEL E MURILO
        //  Perfis de acesso (Roles) e Permissões do sistema
        // ---------------------------------------------------------------------
        Route::resource('roles',       RoleController::class)->except(['show']);
        Route::resource('permissions', PermissionController::class)->except(['show']);
    });
});
