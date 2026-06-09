<?php

// =============================================================================
//  PAINEL DO TÉCNICO (RESOLUÇÃO DE CHAMADOS)
//  Responsável: Dupla 3 — Paulo e Vitor
//  Módulo: Gerenciamento e Painel Técnico
// =============================================================================

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicianController extends Controller
{
    // -------------------------------------------------------------------------
    // Lista chamados abertos que ainda não possuem um técnico atribuído
    // -------------------------------------------------------------------------
    public function pending()
    {
        $tickets = Ticket::with(['categoria', 'user'])
            ->where('status', 'open')
            ->whereNull('technician_id')
            ->orderBy('created_at')
            ->paginate(15);

        return view('technician.pending', compact('tickets'));
    }

    // -------------------------------------------------------------------------
    // Lista os chamados que estão atualmente sob a responsabilidade do técnico logado
    // -------------------------------------------------------------------------
    public function inProgress()
    {
        $tickets = Ticket::with(['categoria', 'user'])
            ->where('technician_id', Auth::id())
            ->whereIn('status', ['open', 'in_progress'])
            ->orderBy('created_at')
            ->paginate(15);

        return view('technician.in_progress', compact('tickets'));
    }

    // -------------------------------------------------------------------------
    // Atribui o chamado ao técnico logado e altera o status para 'Em andamento'
    // -------------------------------------------------------------------------
    public function assign(Ticket $ticket)
    {
        if ($ticket->technician_id) {
            return back()->with('erro', 'Este chamado já possui um técnico atribuído.');
        }

        $ticket->update([
            'technician_id' => Auth::id(),
            'status'        => 'in_progress',
        ]);

        TicketHistory::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => Auth::id(),
            'action'      => 'Atribuição',
            'description' => 'Chamado assumido por '.Auth::user()->name,
        ]);

        return redirect()->route('technician.in-progress')
            ->with('sucesso', 'Chamado atribuído a você com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário para inserir a solução final do chamado
    // -------------------------------------------------------------------------
    public function solutionForm(Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id() && ! Auth::user()->isAdmin()) {
            abort(403, 'Você não tem permissão para resolver este chamado.');
        }

        return view('technician.solution', compact('ticket'));
    }

    // -------------------------------------------------------------------------
    // Salva a solução, marca como 'Resolvido' e registra a data de resolução
    // -------------------------------------------------------------------------
    public function saveSolution(Request $request, Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id() && ! Auth::user()->isAdmin()) {
            abort(403);
        }

        $data = $request->validate([
            'solution' => 'required|string',
        ]);

        $ticket->update([
            'solution'    => $data['solution'],
            'status'      => 'resolved',
            'resolved_at' => now(),
        ]);

        TicketHistory::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => Auth::id(),
            'action'      => 'Resolução',
            'description' => 'Chamado resolvido por '.Auth::user()->name,
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('sucesso', 'Solução registrada e chamado resolvido!');
    }

    // -------------------------------------------------------------------------
    // Visão administrativa geral dos chamados
    // Permite que admins gerenciem chamados globalmente
    // -------------------------------------------------------------------------
    public function manage()
    {
        $tickets = Ticket::with(['categoria', 'user', 'technician'])
            ->orderByDesc('created_at')
            ->paginate(20);

        $tecnicos = \App\Models\User::where('profile', 'Técnico')
            ->orWhere('profile', 'Admin')
            ->orderBy('name')
            ->get();

        return view('technician.manage', compact('tickets', 'tecnicos'));
    }

    // -------------------------------------------------------------------------
    // Permite que o administrador altere forçadamente o status de um chamado
    // (Ex: Reabrir, Fechar definitivamente, etc)
    // -------------------------------------------------------------------------
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $oldStatus = $ticket->status_label;
        $ticket->update(['status' => $data['status']]);
        $newStatus = $ticket->status_label;

        TicketHistory::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => Auth::id(),
            'action'      => 'Alteração de Status',
            'description' => "Status alterado de {$oldStatus} para {$newStatus} pelo Administrador.",
        ]);

        return back()->with('sucesso', 'Status do chamado atualizado.');
    }

    // -------------------------------------------------------------------------
    // Permite que o administrador altere o técnico atribuído ao chamado
    // -------------------------------------------------------------------------
    public function updateTechnician(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'technician_id' => 'nullable|exists:users,id',
        ]);

        $oldTechnician = $ticket->technician?->name ?? 'Nenhum';
        $ticket->update(['technician_id' => $data['technician_id']]);
        $newTechnician = $ticket->technician?->name ?? 'Nenhum';

        TicketHistory::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => Auth::id(),
            'action'      => 'Alteração de Técnico',
            'description' => "Técnico alterado de {$oldTechnician} para {$newTechnician} pelo Administrador.",
        ]);

        return back()->with('sucesso', 'Técnico do chamado atualizado.');
    }
}
