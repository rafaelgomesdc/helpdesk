<?php

use Illuminate\Support\Facades\Route;

Route::get('/abrirChamado', function () {
    return view('solicitante/abrirChamado');
});
