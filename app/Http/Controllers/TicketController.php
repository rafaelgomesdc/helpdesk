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

class TicketController extends Controller
{
    /**
     * Listar "meus chamados"
     */
    public function index()
    {
        $tickets = Ticket::with('categoria')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        //return view('tickets.index', compact('tickets'));
        return view('solicitante.listarChamados', compact('tickets'));
    }

    /**
     * Tela para abrir chamado
     */
    public function create()
    {
        $categorias = Categoria::all();
        
        $prioridades = [
            'low'      => 'Baixa',
            'medium'   => 'Média',
            'high'     => 'Alta',
            'critical' => 'Crítica'
        ];

        return view('tickets.createChamado', compact('categorias', 'prioridades'));
    }

    //Ver chamado específico
    public function viewChamado($ticket_id)
    {
        /*
        $tickets = Ticket::with('categoria')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        */
        //$ticket_id = $_GET['id'];

        $ticket = Ticket::with('categoria')
            ->findOrFail($ticket_id);

        return view('solicitante.comunicacaoChamado', compact('ticket'));
    }

    /**
     * Salvar chamado + Upload de Anexos + Histórico
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'priority'     => 'required|in:low,medium,high,critical',
            'anexos.*'     => 'nullable|file|max:10240', 
        ]);

        DB::beginTransaction();

        try {
            $ticket = Ticket::create([
                'title'        => $request->title,
                'description'  => $request->description,
                'status'       => 'open',
                'priority'     => $request->priority,
                'categoria_id' => $request->categoria_id,
                'user_id'      => Auth::id(),
            ]);

            if ($request->hasFile('anexos')) {
                foreach ($request->file('anexos') as $file) {
                    $path = $file->store('tickets_attachments', 'public');

                    TicketAttachment::create([
                        'ticket_id' => $ticket->id,
                        'filename'  => $file->getClientOriginalName(),
                        'path'      => $path,
                        'size'      => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ]);
                }
            }

            TicketHistory::create([
                'ticket_id'   => $ticket->id,
                'user_id'     => Auth::id(),
                'action'      => 'Chamado Aberto',
                'description' => 'O chamado foi criado com sucesso.',
            ]);

            DB::commit();

            return redirect()->route('tickets.index')->with('success', 'Chamado aberto com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Erro ao abrir o chamado: ' . $e->getMessage());
        }
    }

    /**
     * Visualizar detalhes e linha do tempo
     */
    public function show($id)
    {
        $ticket = Ticket::with([
            'categoria', 
            'attachments', 
            'comentarios.user', 
            'histories.user'
        ])->findOrFail($id);

        if (Auth::user()->role === 'user' && $ticket->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $comentarios = $ticket->comentarios->sortByDesc('created_at');
        $historico = $ticket->histories->sortByDesc('created_at');

        return view('tickets.show', compact('ticket', 'comentarios', 'historico'));
    }

    /**
     * Adicionar comentário
     */
    public function storeComentario(Request $request, $id)
    {
        $request->validate([
            'conteudo' => 'required|string',
        ]);

        $ticket = Ticket::findOrFail($id);

        if (Auth::user()->role === 'user' && $ticket->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        DB::beginTransaction();

        try {
            Comentario::create([
                'ticket_id' => $ticket->id,
                'user_id'   => Auth::id(),
                'conteudo'  => $request->conteudo,
            ]);

            TicketHistory::create([
                'ticket_id'   => $ticket->id,
                'user_id'     => Auth::id(),
                'action'      => 'Novo Comentário',
                'description' => Auth::user()->name . ' adicionou um comentário.',
            ]);

            DB::commit();

            return redirect()->route('tickets.show', $ticket->id)->with('success', 'Comentário adicionado!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao adicionar o comentário.');
        }
    }
}