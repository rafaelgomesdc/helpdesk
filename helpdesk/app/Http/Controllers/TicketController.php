<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Comentario;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        $query = Ticket::with(['categoria', 'technician']);

        if (Auth::user()->role === 'user') {
            $query->where('user_id', Auth::id());
        }

        $tickets = $query->orderByDesc('created_at')->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();
        $prioridades = Ticket::PRIORITY_LABELS;

        return view('tickets.create', compact('categorias', 'prioridades'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'priority' => 'required|in:low,medium,high,critical',
            'anexos.*' => 'nullable|file|max:10240',
        ]);

        DB::beginTransaction();

        try {
            $ticket = Ticket::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => 'open',
                'priority' => $data['priority'],
                'categoria_id' => $data['categoria_id'],
                'user_id' => Auth::id(),
            ]);

            if ($request->hasFile('anexos')) {
                foreach ($request->file('anexos') as $file) {
                    $path = $file->store('tickets_attachments', 'public');
                    TicketAttachment::create([
                        'ticket_id' => $ticket->id,
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ]);
                }
            }

            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'action' => 'Chamado aberto',
                'description' => 'Chamado criado pelo solicitante.',
            ]);

            DB::commit();

            return redirect()->route('tickets.show', $ticket)->with('sucesso', 'Chamado aberto com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('erro', 'Erro ao abrir chamado: '.$e->getMessage());
        }
    }

    public function show(Ticket $ticket)
    {
        $this->authorizeTicket($ticket);

        $ticket->load(['categoria', 'user', 'technician', 'attachments', 'comentarios.user', 'histories.user']);

        return view('tickets.show', compact('ticket'));
    }

    public function storeComentario(Request $request, Ticket $ticket)
    {
        $this->authorizeTicket($ticket);

        $data = $request->validate(['conteudo' => 'required|string']);

        Comentario::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'conteudo' => $data['conteudo'],
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'action' => 'Comentário',
            'description' => Auth::user()->name.' adicionou um comentário.',
        ]);

        return back()->with('sucesso', 'Comentário adicionado!');
    }

    private function authorizeTicket(Ticket $ticket): void
    {
        $user = Auth::user();

        if ($user->role === 'user' && $ticket->user_id !== $user->id) {
            abort(403, 'Acesso não autorizado.');
        }
    }
}
