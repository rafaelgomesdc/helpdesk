<?php

// =============================================================================
//  ABERTURA E ACOMPANHAMENTO DE CHAMADOS
//  Responsável: Dupla 2 — Gustavo e Rafael
//  Módulo: Abertura e Comunicação
// =============================================================================

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Comentario;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TicketController extends Controller
{
    // -------------------------------------------------------------------------
    // Lista os chamados do sistema
    // Usuários comuns enxergam apenas seus próprios chamados
    // Técnicos e Admins enxergam todos os chamados
    // Suporta filtros por status e técnicos não atribuídos
    // -------------------------------------------------------------------------
    public function index(Request $request)
    {
        $query = Ticket::with(['categoria', 'technician', 'user', 'comentarios']);

        if (Auth::user()->role === 'user') {
            $query->where('user_id', Auth::id());
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro para chamados sem técnico (apenas para Admin e Técnico)
        if ($request->filled('unassigned') && $request->unassigned === 'true' && in_array(Auth::user()->profile, ['Admin', 'Técnico'])) {
            $query->whereNull('technician_id');
        }

        $tickets = $query->orderByDesc('created_at')->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    // -------------------------------------------------------------------------
    // Exporta os chamados para um arquivo Excel (.xlsx) via HTML
    // Usuários comuns exportam apenas os próprios chamados
    // -------------------------------------------------------------------------
    public function exportCsv()
    {
        $query = Ticket::with(['categoria', 'technician', 'user']);

        if (Auth::user()->role === 'user') {
            $query->where('user_id', Auth::id());
        }

        $tickets  = $query->orderByDesc('created_at')->get();
        $filename = 'chamados_' . date('Y-m-d') . '.xlsx';

        // Geração do arquivo Excel via HTML estruturado (compatível com Office)
        $html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <!--[if gte mso 9]>
        <xml>
            <x:ExcelWorkbook>
                <x:ExcelWorksheets>
                    <x:ExcelWorksheet>
                        <x:Name>Chamados</x:Name>
                        <x:WorksheetOptions>
                            <x:DisplayGridlines/>
                        </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                </x:ExcelWorksheets>
            </x:ExcelWorkbook>
        </xml>
        <![endif]-->
        </head>
        <body>
        <table border="1">
            <thead>
                <tr style="background-color: #4F46E5; color: white;">
                    <th style="padding: 10px;">ID</th>
                    <th style="padding: 10px;">Título</th>
                    <th style="padding: 10px;">Categoria</th>
                    <th style="padding: 10px;">Prioridade</th>
                    <th style="padding: 10px;">Status</th>
                    <th style="padding: 10px;">Solicitante</th>
                    <th style="padding: 10px;">Técnico</th>
                    <th style="padding: 10px;">Data Abertura</th>
                    <th style="padding: 10px;">Data Resolução</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($tickets as $ticket) {
            $html .= '<tr>
                <td style="padding: 8px;">' . $ticket->id . '</td>
                <td style="padding: 8px;">' . htmlspecialchars($ticket->title) . '</td>
                <td style="padding: 8px;">' . htmlspecialchars($ticket->categoria?->nome ?? '—') . '</td>
                <td style="padding: 8px;">' . htmlspecialchars($ticket->priority_label) . '</td>
                <td style="padding: 8px;">' . htmlspecialchars($ticket->status_label) . '</td>
                <td style="padding: 8px;">' . htmlspecialchars($ticket->user?->name ?? '—') . '</td>
                <td style="padding: 8px;">' . htmlspecialchars($ticket->technician?->name ?? 'Não atribuído') . '</td>
                <td style="padding: 8px;">' . $ticket->created_at->format('d/m/Y H:i') . '</td>
                <td style="padding: 8px;">' . ($ticket->resolved_at ? $ticket->resolved_at->format('d/m/Y H:i') : '—') . '</td>
            </tr>';
        }

        $html .= '</tbody>
        </table>
        </body>
        </html>';

        $headers = [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response($html, 200, $headers);
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de abertura de novo chamado
    // Carrega as categorias disponíveis e os rótulos de prioridade
    // -------------------------------------------------------------------------
    public function create()
    {
        $categorias  = Categoria::orderBy('nome')->get();
        $prioridades = Ticket::PRIORITY_LABELS;

        return view('tickets.create', compact('categorias', 'prioridades'));
    }

    // -------------------------------------------------------------------------
    // Persiste o novo chamado no banco de dados
    // Salva anexos (se houver) e registra o histórico de abertura
    // Utiliza transação para garantir consistência dos dados
    // -------------------------------------------------------------------------
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'categoria_id'=> 'required|exists:categorias,id',
            'priority'    => 'required|in:low,medium,high,critical',
            'anexos.*'    => 'nullable|file|max:10240',
        ]);

        DB::beginTransaction();

        try {
            // Cria o chamado principal
            $ticket = Ticket::create([
                'title'        => $data['title'],
                'description'  => $data['description'],
                'status'       => 'open',
                'priority'     => $data['priority'],
                'categoria_id' => $data['categoria_id'],
                'user_id'      => Auth::id(),
            ]);

            // Processa e salva os arquivos anexados
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

            // Registra o evento de abertura no histórico do chamado
            TicketHistory::create([
                'ticket_id'   => $ticket->id,
                'user_id'     => Auth::id(),
                'action'      => 'Chamado aberto',
                'description' => 'Chamado criado pelo solicitante.',
            ]);

            DB::commit();

            return redirect()->route('tickets.show', $ticket)->with('sucesso', 'Chamado aberto com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('erro', 'Erro ao abrir chamado: '.$e->getMessage());
        }
    }

    // -------------------------------------------------------------------------
    // Exibe os detalhes completos de um chamado
    // Carrega categoria, solicitante, técnico, anexos, comentários e histórico
    // -------------------------------------------------------------------------
    public function show(Ticket $ticket)
    {
        $this->authorizeTicket($ticket);

        $ticket->load(['categoria', 'user', 'technician', 'attachments', 'comentarios.user', 'histories.user']);

        return view('tickets.show', compact('ticket'));
    }

    // -------------------------------------------------------------------------
    // Adiciona um comentário ao chamado
    // Registra também o evento no histórico para rastreabilidade
    // -------------------------------------------------------------------------
    public function storeComentario(Request $request, Ticket $ticket)
    {
        $this->authorizeTicket($ticket);

        $data = $request->validate(['conteudo' => 'required|string']);

        Comentario::create([
            'ticket_id' => $ticket->id,
            'user_id'   => Auth::id(),
            'conteudo'  => $data['conteudo'],
        ]);

        TicketHistory::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => Auth::id(),
            'action'      => 'Comentário',
            'description' => Auth::user()->name.' adicionou um comentário.',
        ]);

        return back()->with('sucesso', 'Comentário adicionado!');
    }

    // -------------------------------------------------------------------------
    // Garante que usuários comuns só acessem os próprios chamados
    // Lança HTTP 403 caso o usuário tente acessar chamado de terceiros
    // -------------------------------------------------------------------------
    private function authorizeTicket(Ticket $ticket): void
    {
        $user = Auth::user();

        if ($user->role === 'user' && $ticket->user_id !== $user->id) {
            abort(403, 'Acesso não autorizado.');
        }
    }
}
