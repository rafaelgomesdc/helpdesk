<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Categoria;
use App\Models\Comentario;
use App\Models\TicketAttachment;
use App\Models\TicketHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChamadosController extends Controller
{
    public function viewAbrirChamado(){
        $categorias = Categoria::orderBy('nome')->get();
        return view('solicitante.abrirChamado', compact('categorias'));
    }

    public function viewListarChamados(){

        $tickets = Ticket::with('categoria')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('solicitante.listarChamados', compact('tickets'));

        //$chamados = [];
        //return view('solicitante.listarChamados', compact('chamados'));
    }
    
    public function viewComunicacaoChamados(){
        return view('solicitante.comunicacaoChamado');
    }
}
