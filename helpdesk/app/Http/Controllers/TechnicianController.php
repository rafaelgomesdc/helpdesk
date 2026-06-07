<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicianController extends Controller
{
    public function pending()
    {
        $tickets = Ticket::with(['user', 'categoria'])
            ->where('status', 'open')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('technician.pending', compact('tickets'));
    }

    public function inProgress()
    {
        $tickets = Ticket::with(['user', 'categoria'])
            ->where('status', 'in_progress')
            ->when(Auth::user()->profile === 'Técnico', fn ($q) => $q->where('technician_id', Auth::id()))
            ->orderByDesc('updated_at')
            ->paginate(15);

        return view('technician.in_progress', compact('tickets'));
    }

    public function assign(Ticket $ticket)
    {
        if ($ticket->status !== 'open') {
            return back()->with('erro', 'Este chamado não pode ser atribuído.');
        }

        $ticket->update([
            'technician_id' => Auth::id(),
            'status' => 'in_progress',
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'action' => 'Atribuição',
            'description' => 'Chamado assumido por '.Auth::user()->name,
        ]);

        return redirect()->route('technician.in-progress')->with('sucesso', "Chamado #{$ticket->id} assumido!");
    }

    public function solutionForm(Ticket $ticket)
    {
        $ticket->load(['user', 'technician', 'histories.user', 'attachments', 'comentarios.user']);

        return view('technician.solution', compact('ticket'));
    }

    public function saveSolution(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'solution' => 'required|string|min:10',
            'attachment' => 'nullable|file|max:10240',
            'status' => 'required|in:resolved,closed',
        ]);

        $ticket->update([
            'solution' => $data['solution'],
            'status' => $data['status'],
            'resolved_at' => now(),
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('ticket-attachments', 'public');
            TicketAttachment::create([
                'ticket_id' => $ticket->id,
                'filename' => $file->getClientOriginalName(),
                'path' => $path,
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]);
        }

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'action' => 'Solução registrada',
            'description' => 'Chamado marcado como '.$ticket->status_label.'.',
        ]);

        return redirect()->route('technician.in-progress')->with('sucesso', 'Solução registrada com sucesso!');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'technician_id' => 'nullable|exists:users,id',
        ]);

        $ticket->update([
            'status' => $data['status'],
            'technician_id' => $data['technician_id'] ?? $ticket->technician_id,
            'resolved_at' => in_array($data['status'], ['resolved', 'closed']) ? now() : null,
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'action' => 'Status alterado',
            'description' => 'Status atualizado para '.$ticket->status_label,
        ]);

        return back()->with('sucesso', 'Status do chamado atualizado.');
    }

    public function manage()
    {
        $tickets = Ticket::with(['user', 'technician', 'categoria'])
            ->orderByDesc('created_at')
            ->paginate(20);

        $tecnicos = User::whereIn('profile', ['Técnico', 'Admin'])->orderBy('name')->get();

        return view('technician.manage', compact('tickets', 'tecnicos'));
    }
}
