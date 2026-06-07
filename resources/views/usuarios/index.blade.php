@extends('layouts.app')
@section('title', 'Usuários')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Usuários</h1>
        <p class="page-subtitle">Cadastro e gestão de colaboradores do sistema</p>
    </div>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">+ Novo Usuário</a>
</div>

@if($pendentes > 0)
<div class="flash flash-error" style="background:rgba(245,158,11,0.08); border-color:rgba(245,158,11,0.2); color:#fcd34d;">
    ⏳ {{ $pendentes }} solicitação(ões) aguardando aprovação
</div>
@endif

<div class="table-wrap">
    <div class="table-header">
        <span class="table-title">{{ $usuarios->count() }} usuário(s) cadastrado(s)</span>
    </div>

    @if($usuarios->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">👥</div>
            <div class="empty-text">Nenhum usuário cadastrado ainda.</div>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Perfil</th>
                    <th>Setor</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $u)
                <tr>
                    <td style="font-weight:600; color:var(--text-primary);">{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td><span class="badge badge-blue">{{ $u->profile }}</span></td>
                    <td>{{ $u->setor?->nome ?? '—' }}</td>
                    <td>
                        @php
                            $badge = match($u->status) {
                                'Ativo' => 'badge-green',
                                'Pendente' => 'badge-amber',
                                default => 'badge-rose',
                            };
                        @endphp
                        <span class="badge {{ $badge }}">{{ $u->status }}</span>
                    </td>
                    <td>
                        <div style="display:flex; gap:6px; flex-wrap:wrap;">
                            @if($u->status === 'Pendente')
                                <form action="{{ route('usuarios.aprovar', $u) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">✓ Aprovar</button>
                                </form>
                                <form action="{{ route('usuarios.rejeitar', $u) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Rejeitar {{ $u->name }}?')">✗ Rejeitar</button>
                                </form>
                            @endif
                            <a href="{{ route('usuarios.show', $u) }}" class="btn btn-ghost btn-sm">Ver</a>
                            <a href="{{ route('usuarios.edit', $u) }}" class="btn btn-ghost btn-sm">Editar</a>
                            <form action="{{ route('usuarios.destroy', $u) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Excluir {{ $u->name }}?')">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
