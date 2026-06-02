<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ControllerChamados extends Controller
{
    
    //FORMS
    public function create(){
        return view('função.createChamado');
    }

    //SALVAR FORMS
    public function save(Request $request){
        $dados = $request->validate([
            'nome'

        ])
    }
}