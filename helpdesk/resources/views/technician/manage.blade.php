@extends('layouts.app')
@section('title', 'Gerenciar Chamados')

@section('content')

<div class="page-header manage-header">
    <div>
        <h1 class="page-title">Gerenciar Chamados</h1>
        <p class="page-subtitle">Atualize status e responsáveis técnicos dos chamados.</p>
    </div>
</div>

<div class="table-wrap manage-table">
    <div class="table-header">
        <span class="table-title">Chamados cadastrados</span>
        <span class="table-count">{{ $tickets->total() }} registro{{ $tickets->total() != 1 ? 's' : '' }}</span>
    </div>


<table>
    <thead>
        <tr>
            <th style="width: 70px;">ID</th>
            <th>Chamado</th>
            <th style="width: 140px;">Status</th>
            <th style="width: 170px;">Técnico</th>
            <th style="width: 330px;">Atualização rápida</th>
        </tr>
    </thead>

    <tbody>
        @forelse($tickets as $t)
            <tr>
                <td>
                    <span class="ticket-id">#{{ $t->id }}</span>
                </td>

                <td>
                    <a href="{{ route('tickets.show', $t) }}" class="ticket-title">
                        {{ $t->title }}
                    </a>
                </td>

                <td>
                    <span class="badge">
                        {{ $t->status_label }}
                    </span>
                </td>

                <td>
                    <span class="tech-name">
                        {{ $t->technician?->name ?? '—' }}
                    </span>
                </td>

                <td>
                    <div class="quick-actions">
                        <form action="{{ route('technician.update-status', $t) }}" method="POST">
                            @csrf

                            <select name="status" class="manage-select" onchange="this.form.submit()">
                                @foreach(\App\Models\Ticket::STATUS_LABELS as $k => $v)
                                    <option value="{{ $k }}" @selected($t->status == $k)>
                                        {{ $v }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        <form action="{{ route('technician.update-technician', $t) }}" method="POST">
                            @csrf

                            <select name="technician_id" class="manage-select" onchange="this.form.submit()">
                                <option value="">Técnico</option>

                                @foreach($tecnicos as $tec)
                                    <option value="{{ $tec->id }}" @selected($t->technician_id == $tec->id)>
                                        {{ $tec->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <div class="empty-icon">—</div>
                        <div class="empty-text">Nenhum chamado encontrado.</div>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination-wrap">
    {{ $tickets->links() }}
</div>

</div>

@endsection

@push('head')

<style>
    .manage-header {
        margin-bottom: 20px;
    }

    .manage-table {
        overflow: hidden;
    }

    .table-count {
        color: var(--text-muted);
        font-size: 11px;
        font-weight: 600;
    }

    .ticket-id {
        color: var(--text-muted);
        font-size: 12px;
        font-weight: 700;
    }

    .ticket-title {
        color: var(--text-primary);
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        max-width: 360px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ticket-title:hover {
        color: var(--accent-hover);
    }

    .tech-name {
        color: var(--text-secondary);
        font-size: 12px;
        font-weight: 500;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        align-items: center;
        max-width: 300px;
    }

    .quick-actions form {
        margin: 0;
    }

    .manage-select {
        width: 100%;
        height: 32px;
        background: #080a0f;
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text-secondary);
        font-size: 11px;
        font-weight: 600;
        padding: 0 28px 0 10px;
        outline: none;
        cursor: pointer;
        transition: 0.15s ease;
    }

    .manage-select:hover {
        border-color: var(--accent);
        color: var(--text-primary);
        background: var(--bg-hover);
    }

    .manage-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .manage-select option {
        background: var(--bg-header);
        color: var(--text-primary);
    }

    .pagination-wrap {
        padding: 14px 18px;
        border-top: 1px solid var(--border);
    }

    .pagination-wrap nav {
        margin: 0;
    }

    .pagination {
        margin: 0;
        gap: 5px;
        flex-wrap: wrap;
    }

    .page-link {
        background: var(--bg-card) !important;
        border: 1px solid var(--border) !important;
        color: var(--text-secondary) !important;
        border-radius: 8px !important;
        font-size: 11px;
        padding: 6px 10px;
    }

    .page-link:hover {
        background: var(--bg-hover) !important;
        color: var(--text-primary) !important;
        border-color: var(--accent) !important;
    }

    .page-item.active .page-link {
        background: rgba(37, 99, 235, 0.18) !important;
        color: var(--text-primary) !important;
        border-color: var(--accent) !important;
    }

    .page-item.disabled .page-link {
        opacity: 0.45;
    }

    @media (max-width: 900px) {
        .quick-actions {
            grid-template-columns: 1fr;
            max-width: 190px;
        }

        .ticket-title {
            max-width: 240px;
        }
    }
</style>

@endpush
