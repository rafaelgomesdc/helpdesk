@extends('layouts.app')
@section('title', 'Usuários')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Usuários</h1>
        <p class="page-subtitle mb-0 text-secondary">Controle de colaboradores, cargos, setores e níveis de permissão</p>
    </div>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
        ➕ Novo Colaborador
    </a>
</div>

<!-- Seção 1: Solicitações de Acesso Pendentes (Destaque Administrativo) -->
@php
    $listaPendentes = $usuarios->where('status', 'Pendente');
@endphp

@if($pendentes > 0)
<div class="table-wrap mb-4" style="border-color: rgba(245, 158, 11, 0.22); background: rgba(245, 158, 11, 0.01);">
    <div class="table-header d-flex justify-content-between align-items-center" style="border-bottom: 1px solid rgba(245, 158, 11, 0.15);">
        <span class="table-title text-warning" style="font-weight: 700;">⏳ Solicitações de Acesso Aguardando Liberação ({{ $pendentes }})</span>
    </div>
    
    <div class="table-responsive">
        <table class="align-middle">
            <thead>
                <tr style="background-color: rgba(245, 158, 11, 0.03);">
                    <th style="color: var(--amber);">Nome</th>
                    <th style="color: var(--amber);">E-mail</th>
                    <th style="color: var(--amber);">Setor / Cargo</th>
                    <th style="color: var(--amber);">Nível Solicitado</th>
                    <th style="width: 200px; text-align: center; color: var(--amber);">Decisão</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listaPendentes as $u)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; border-radius: 50%; background-color: rgba(245, 158, 11, 0.15); color: var(--amber); font-size: 11px;">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <span class="fw-bold text-light">{{ $u->name }}</span>
                        </div>
                    </td>
                    <td class="font-mono small">{{ $u->email }}</td>
                    <td class="small">{{ $u->setor?->nome ?? '—' }} · {{ $u->cargo?->nome ?? '—' }}</td>
                    <td><span class="badge badge-blue">{{ $u->profile }}</span></td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <form action="{{ route('usuarios.aprovar', $u) }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--emerald); font-size: 10px; padding: 4px 8px;">
                                    ✓ Aprovar
                                </button>
                            </form>
                            <form action="{{ route('usuarios.rejeitar', $u) }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" style="font-size: 10px; padding: 4px 8px;"
                                    onclick="return confirm('Rejeitar o cadastro de {{ $u->name }}?')">
                                    ✗ Rejeitar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Seção 2: Lista Geral de Usuários -->
<div class="table-wrap">
    <div class="table-header">
        <span class="table-title">Lista Geral de Colaboradores ({{ $usuarios->count() }})</span>
    </div>

    @if($usuarios->isEmpty())
        <div class="empty-state py-5">
            <div class="empty-icon fs-2">👥</div>
            <div class="empty-text text-muted mt-2">Nenhum colaborador cadastrado no banco de dados.</div>
        </div>
    @else
        <div class="table-responsive">
            <table class="align-middle">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th>Setor / Cargo</th>
                        <th>Status</th>
                        <th style="width: 220px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $u)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @php
                                    $avatarBg = match($u->profile) {
                                        'Admin' => 'rgba(16, 185, 129, 0.12)',
                                        'Técnico' => 'rgba(59, 130, 246, 0.12)',
                                        default => 'rgba(148, 163, 184, 0.12)'
                                    };
                                    $avatarColor = match($u->profile) {
                                        'Admin' => 'var(--emerald)',
                                        'Técnico' => 'var(--blue-400)',
                                        default => 'var(--text-secondary)'
                                    };
                                @endphp
                                <div class="d-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; border-radius: 50%; background-color: {{ $avatarBg }}; color: {{ $avatarColor }}; font-size: 11px;">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <span class="fw-bold text-light">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td class="font-mono small">{{ $u->email }}</td>
                        <td>
                            <span class="badge {{ $u->profile === 'Admin' ? 'badge-green' : ($u->profile === 'Técnico' ? 'badge-blue' : 'badge-blue') }}" style="{{ $u->profile === 'Usuário' ? 'background-color: rgba(148, 163, 184, 0.15) !important; color: #94a3b8 !important;' : '' }}">
                                {{ $u->profile }}
                            </span>
                        </td>
                        <td class="small text-secondary">{{ $u->setor?->nome ?? '—' }} <br> <span class="text-muted" style="font-size: 11px;">{{ $u->cargo?->nome ?? '—' }}</span></td>
                        <td>
                            @php
                                $statusBadge = match($u->status) {
                                    'Ativo' => 'badge-green',
                                    'Pendente' => 'badge-amber',
                                    'Rejeitado' => 'badge-rose',
                                    default => 'badge-rose'
                                };
                            @endphp
                            <span class="badge {{ $statusBadge }}">{{ $u->status }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('usuarios.show', $u) }}" class="btn btn-ghost btn-sm">Ver</a>
                                <a href="{{ route('usuarios.edit', $u) }}" class="btn btn-ghost btn-sm">Editar</a>
                                <form action="{{ route('usuarios.destroy', $u) }}" method="POST" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Tem certeza que deseja excluir permanentemente o colaborador {{ $u->name }}?')">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
