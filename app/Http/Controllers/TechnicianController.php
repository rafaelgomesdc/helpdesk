<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicianController extends Controller
{
    public function inProgress()
    {
        $tickets = Ticket::where('technician_id', Auth::id())
            ->where('status', 'in_progress')
            ->with(['user', 'technician'])
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('technician.in_progress', compact('tickets'));
    }

    public function assign($id)
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->status !== 'open') {
            return back()->with('error', 'Este chamado não pode ser atribuído (status: ' . $ticket->status_label . ').');
        }

        $ticket->update([
            'technician_id' => Auth::id(),
            'status'        => 'in_progress',
        ]);

        TicketHistory::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => Auth::id(),
            'action'      => 'assigned',
            'description' => 'Chamado assumido pelo técnico ' . Auth::user()->name,
        ]);

        return redirect()->route('technician.in-progress')
            ->with('success', 'Chamado #' . $ticket->id . ' assumido com sucesso!');
    }

    public function solutionForm($id)
    {
        $ticket = Ticket::with(['user', 'technician', 'histories.user', 'attachments'])
            ->findOrFail($id);

        return view('technician.solution', compact('ticket'));
    }

    public function saveSolution(Request $request, $id)
    {
        $request->validate([
            'solution'   => 'required|string|min:10',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,png,jpg,jpeg,txt,zip',
        ]);

        $ticket = Ticket::findOrFail($id);

        $ticket->update([
            'solution' => $request->input('solution'),
            'status'   => 'resolved',
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('ticket-attachments', 'public');

            TicketAttachment::create([
                'ticket_id' => $ticket->id,
                'filename'  => $file->getClientOriginalName(),
                'path'      => $path,
                'size'      => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]);
        }

        TicketHistory::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => Auth::id(),
            'action'      => 'solution_registered',
            'description' => 'Solução registrada e chamado marcado como Resolvido.',
        ]);

        return redirect()->route('technician.in-progress')
            ->with('success', 'Solução registrada! Chamado #' . $ticket->id . ' marcado como Resolvido.');

        
    }

    public function pending()
    {
        $tickets = Ticket::where('status', 'open')
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('technician.pending', compact('tickets'));
    }

    public function history($id)
    {
        $ticket = Ticket::with('histories.user')->findOrFail($id);
        return view('technician.history', compact('ticket'));
    }
}
