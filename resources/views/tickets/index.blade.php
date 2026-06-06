@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Meus Chamados</h1>
        <p class="page-subtitle">Acompanhe o status e histórico das suas solicitações.</p>
    </div>
    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
        + Abrir Chamado
    </a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Categoria</th>
                <th>Prioridade</th>
                <th>Status</th>
                <th>Data</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tickets as $ticket)
                <tr>
                    <td style="font-family: 'IBM Plex Mono', monospace; color: var(--text-muted);">#{{ $ticket->id }}</td>
                    <td style="color: var(--text-primary); font-weight: 500;">{{ $ticket->title }}</td>
                    <td>{{ $ticket->categoria->nome ?? 'N/A' }}</td>
                    
                    <td>
                        @if($ticket->priority == 'low') <span style="color: var(--emerald);">Baixa</span>
                        @elseif($ticket->priority == 'medium') <span style="color: var(--amber);">Média</span>
                        @elseif($ticket->priority == 'high') <span style="color: var(--rose);">Alta</span>
                        @else <span style="color: var(--rose); font-weight: 700;">Crítica</span>
                        @endif
                    </td>
                    
                    <td>
                        @if($ticket->status == 'open') 
                            <span class="status-badge" style="background: var(--bg-800); color: var(--blue-400);">Aberto</span>
                        @elseif($ticket->status == 'in_progress') 
                            <span class="status-badge" style="background: var(--bg-800); color: var(--amber);">Em Andamento</span>
                        @elseif($ticket->status == 'resolved') 
                            <span class="status-badge" style="background: var(--bg-800); color: var(--emerald);">Resolvido</span>
                        @else 
                            <span class="status-badge" style="background: var(--bg-800); color: var(--text-muted);">Fechado</span>
                        @endif
                    </td>
                    
                    <td style="font-size: 11px;">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                    <td style="text-align: right;">
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-ghost btn-sm">Ver</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-icon">📁</div>
                            <div class="empty-text">Nenhum chamado aberto ainda.</div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 20px;">
    {{ $tickets->links('pagination::bootstrap-4') }} </div>
@endsection