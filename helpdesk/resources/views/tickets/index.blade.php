@extends('layouts.app')
@section('title', 'Meus Chamados')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Chamados</h1>
        <p class="page-subtitle mb-0 text-secondary">
            @if(in_array(auth()->user()->profile, ['Admin', 'Técnico']))
                Painel Geral — Gerenciamento e Atendimento de Fila
            @else
                Seus chamados e solicitações abertas no portal
            @endif
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('tickets.export-csv') }}" class="btn btn-ghost">
            📥 Exportar
        </a>
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
            ➕ Abrir Chamado
        </a>
    </div>
</div>

<!-- Filtros Rápidos -->
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('tickets.index') }}" class="btn btn-ghost btn-sm {{ request()->has('status') ? '' : 'active' }}" style="background: var(--bg-800);">
        Todos
    </a>
    <a href="{{ route('tickets.index', ['status' => 'open']) }}" class="btn btn-ghost btn-sm {{ request('status') === 'open' ? 'active' : '' }}" style="background: var(--bg-800);">
        <span class="badge badge-amber">●</span> Abertos
    </a>
    <a href="{{ route('tickets.index', ['status' => 'in_progress']) }}" class="btn btn-ghost btn-sm {{ request('status') === 'in_progress' ? 'active' : '' }}" style="background: var(--bg-800);">
        <span class="badge badge-blue">●</span> Em Andamento
    </a>
    <a href="{{ route('tickets.index', ['status' => 'resolved']) }}" class="btn btn-ghost btn-sm {{ request('status') === 'resolved' ? 'active' : '' }}" style="background: var(--bg-800);">
        <span class="badge badge-green">●</span> Resolvidos
    </a>
    @if(in_array(auth()->user()->profile, ['Admin', 'Técnico']))
        <a href="{{ route('tickets.index', ['unassigned' => 'true']) }}" class="btn btn-ghost btn-sm {{ request('unassigned') === 'true' ? 'active' : '' }}" style="background: var(--bg-800);">
            <span class="badge badge-rose">●</span> Sem Técnico
        </a>
    @endif
</div>

<div class="table-wrap">
    <div class="table-header">
        <span class="table-title">Lista de Chamados ({{ $tickets->count() }})</span>
    </div>

    @if($tickets->isEmpty())
        <div class="empty-state py-5">
            <div class="empty-icon fs-2">📋</div>
            <div class="empty-text text-muted mt-2">Nenhum chamado encontrado nesta fila de atendimento.</div>
        </div>
    @else
        <div class="table-responsive">
            <table class="align-middle">
                <thead>
                    <tr>
                        <th style="width: 70px;">ID</th>
                        <th>Título / Assunto</th>
                        <th style="width: 140px;">Solicitante</th>
                        <th style="width: 120px;">Categoria</th>
                        <th style="width: 100px;">Prioridade</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 140px;">Técnico</th>
                        <th style="width: 90px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $t)
                    <tr style="cursor: pointer;" onclick="window.location.href='{{ route('tickets.show', $t) }}'">
                        <td class="font-mono text-muted small">{{ $t->id }}</td>
                        <td>
                            <div class="fw-bold text-light" style="font-size: 13.5px;">{{ $t->title }}</div>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <span class="text-muted small" style="font-size: 11px;">{{ $t->created_at?->format('d/m/Y H:i') }}</span>
                                @if($t->comentarios->count() > 0)
                                    <span class="badge" style="background: rgba(59, 130, 246, 0.1); color: var(--blue-400); font-size: 9px; padding: 2px 6px;">💬 {{ $t->comentarios->count() }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--bg-800); font-size: 10px; font-weight: 700; color: var(--text-secondary);">
                                    {{ strtoupper(substr($t->user?->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="small text-truncate" style="max-width: 100px;">{{ $t->user?->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="text-secondary small text-truncate d-block" style="max-width: 110px;">{{ $t->categoria?->nome ?? '—' }}</span>
                        </td>
                        <td>
                            @php
                                $prioClass = match($t->priority) {
                                    'low' => 'badge-blue',
                                    'medium' => 'badge-amber',
                                    'high' => 'badge-rose',
                                    'critical' => 'badge-rose',
                                    default => 'badge-blue'
                                };
                                $prioStyle = $t->priority === 'critical' ? 'background-color: rgba(244,63,94,0.22) !important; font-weight: 800;' : '';
                            @endphp
                            <span class="badge {{ $prioClass }}" style="{{ $prioStyle }}">{{ $t->priority_label }}</span>
                        </td>
                        <td>
                            @php
                                $statusClass = match($t->status) {
                                    'open' => 'badge-amber',
                                    'in_progress' => 'badge-blue',
                                    'resolved' => 'badge-green',
                                    'closed' => 'badge-green',
                                    default => 'badge-rose'
                                };
                                $statusStyle = $t->status === 'closed' ? 'background-color: rgba(148, 163, 184, 0.15) !important; color: #cbd5e1 !important;' : '';
                            @endphp
                            <span class="badge {{ $statusClass }}" style="{{ $statusStyle }}">{{ $t->status_label }}</span>
                        </td>
                        <td>
                            @if($t->technician)
                                <div class="d-flex align-items-center gap-2">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 50%; background-color: rgba(59, 130, 246, 0.1); font-size: 10px; font-weight: 700; color: var(--blue-400);">
                                        {{ strtoupper(substr($t->technician->name, 0, 1)) }}
                                    </div>
                                    <span class="small text-truncate" style="max-width: 85px;">{{ $t->technician->name }}</span>
                                </div>
                            @else
                                <span class="text-muted small fst-italic">—</span>
                            @endif
                        </td>
                        <td style="text-align: center;" onclick="event.stopPropagation()">
                            <a href="{{ route('tickets.show', $t) }}" class="btn btn-ghost btn-sm">
                                👁️
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Links de Paginação estilizados -->
        @if($tickets->hasPages())
            <div class="border-top p-3 d-flex justify-content-center" style="border-color: var(--border) !important;">
                {{ $tickets->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
