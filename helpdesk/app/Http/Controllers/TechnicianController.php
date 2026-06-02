<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class TechnicianController extends Controller
{
    // Chamados Pendentes
    public function pending()
    {
        $tickets = Ticket::where(
            'status',
            'open'
        )->get();

        return view(
            'technician.pending',
            compact('tickets')
        );
    }

    // Chamados em Atendimento
    public function inProgress()
    {
        $tickets = Ticket::where(
            'status',
            'in_progress'
        )->get();

        return view(
            'technician.in_progress',
            compact('tickets')
        );
    }

    // Histórico
    public function history($id)
    {
        $ticket = Ticket::with(
            'histories'
        )->findOrFail($id);

        return view(
            'technician.history',
            compact('ticket')
        );
    }
}