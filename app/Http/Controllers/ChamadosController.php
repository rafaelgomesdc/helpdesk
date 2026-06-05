<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categoria;

class ChamadosController extends Controller
{
    public function viewAbrirChamado(){
        $categorias = Categoria::orderBy('nome')->get();
        return view('solicitante.abrirChamado', compact('categorias'));
    }
}
