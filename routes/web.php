<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChamadosController;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('categorias', CategoriaController::class);

//Abertura e comunicação de chamados (Dupla 2)
Route::get('/abrirChamado', [ChamadosController::class, 'viewAbrirChamado']); //Abrir chamado
Route::get('/listarChamados', [TicketController::class, 'index'])->name('tickets.index');
//Route::get('/listarChamados', [ChamadosController::class, 'viewListarChamados']); //Consultar chamados
Route::get('/chamado', [ChamadosController::class, 'viewComunicacaoChamados']); //Consultar chamados

Route::middleware(['auth'])->group(function () {
    Route::get('/meus-chamados', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/chamados/novo', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/chamados/salvar', [TicketController::class, 'store'])->name('tickets.store');
    
    Route::get('/chamados/{id}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/chamados/{id}/comentar', [TicketController::class, 'storeComentario'])->name('tickets.comentario.store');
});