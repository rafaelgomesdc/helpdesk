@extends('layouts.app')
@section('title', $usuario->name)
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">{{ $usuario->name }}</h1>
        <p class="page-subtitle">Detalhes do colaborador</p>
    </div>
    <div style="display:flex; gap:8px; flex-wrap:wrap;">
        @if($usuario->status === 'Pendente')
            <form action="{{ route('usuarios.aprovar', $usuario) }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="btn btn-primary">✓ Aprovar acesso</button>
            </form>
            <form action="{{ route('usuarios.rejeitar', $usuario) }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Rejeitar esta solicitação?')">✗ Rejeitar</button>
            </form>
        @endif
        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-ghost">Editar</a>
        <a href="{{ route('usuarios.index') }}" class="btn btn-ghost">Voltar</a>
    </div>
</div>

<div class="detail-grid" style="margin-bottom:24px;">
    <div class="detail-item">
        <div class="detail-label">E-mail</div>
        <div class="detail-value">{{ $usuario->email }}</div>
    </div>
    <div class="detail-item">
        <div class="detail-label">Telefone</div>
        <div class="detail-value">{{ $usuario->phone ?? '—' }}</div>
    </div>
    <div class="detail-item">
        <div class="detail-label">Endereço</div>
        <div class="detail-value">{{ $usuario->address ?? '—' }}</div>
    </div>
    <div class="detail-item">
        <div class="detail-label">Setor</div>
        <div class="detail-value">{{ $usuario->setor?->nome ?? '—' }}</div>
    </div>
    <div class="detail-item">
        <div class="detail-label">Cargo</div>
        <div class="detail-value">{{ $usuario->cargo?->nome ?? '—' }}</div>
    </div>
    <div class="detail-item">
        <div class="detail-label">Perfil de acesso</div>
        <div class="detail-value"><span class="badge badge-blue">{{ $usuario->profile }}</span></div>
    </div>
    <div class="detail-item">
        <div class="detail-label">Status</div>
        <div class="detail-value">
            @php $badge = $usuario->status === 'Ativo' ? 'badge-green' : ($usuario->status === 'Pendente' ? 'badge-amber' : 'badge-rose'); @endphp
            <span class="badge {{ $badge }}">{{ $usuario->status }}</span>
        </div>
    </div>
    <div class="detail-item">
        <div class="detail-label">Perfil (Role)</div>
        <div class="detail-value">{{ $usuario->accessRole?->name ?? '—' }}</div>
    </div>
    <div class="detail-item">
        <div class="detail-label">Pergunta de segurança</div>
        <div class="detail-value">{{ $usuario->security_question ?? '—' }}</div>
    </div>
</div>

@if($usuario->accessRole && $usuario->accessRole->permissions->isNotEmpty())
<div class="table-wrap">
    <div class="table-header">
        <span class="table-title">Permissões do perfil</span>
    </div>
    <div style="padding:20px;">
        <div class="perm-list">
            @foreach($usuario->accessRole->permissions as $perm)
                <span class="perm-chip">{{ $perm->name }}</span>
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection
