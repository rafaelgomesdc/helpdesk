<?php

use App\Http\Controllers\TechnicianController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get(
    '/tecnico/pendentes',
    [TechnicianController::class, 'pending']
);

Route::get(
    '/tecnico/em-atendimento',
    [TechnicianController::class, 'inProgress']
);

Route::get(
    '/tecnico/historico/{id}',
    [TechnicianController::class, 'history']
);



