<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TechnicianController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('tecnico')->name('technician.')->group(function () {
    Route::get('/em-atendimento',          [TechnicianController::class, 'inProgress'])->name('in-progress');
    Route::post('/chamados/{id}/atribuir', [TechnicianController::class, 'assign'])->name('assign');
    Route::get('/chamados/{id}/solucao',   [TechnicianController::class, 'solutionForm'])->name('solution');
    Route::post('/chamados/{id}/solucao',  [TechnicianController::class, 'saveSolution'])->name('save-solution');
    Route::get('/pendentes',       [TechnicianController::class, 'pending'])->name('pendentes');
    Route::get('/historico/{id}',  [TechnicianController::class, 'history'])->name('historico');
});
