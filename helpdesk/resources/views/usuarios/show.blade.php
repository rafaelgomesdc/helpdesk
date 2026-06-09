@extends('layouts.app')
@section('title', $usuario->name)
@section('content')

<div class="page-header d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
    <div>
        <h1 class="page-title mb-1">{{ $usuario->name }}</h1>
        <p class="page-subtitle mb-0 text-secondary">Detalhes cadastrais e permissões de acesso do colaborador</p>
    </div>
    <div class="d-flex gap-2">
        @if($usuario->status === 'Pendente')
            <form action="{{ route('usuarios.aprovar', $usuario) }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="btn btn-primary" style="background-color: var(--emerald);">✓ Aprovar Acesso</button>
            </form>
            <form action="{{ route('usuarios.rejeitar', $usuario) }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Rejeitar esta solicitação de acesso?')">✗ Rejeitar</button>
            </form>
        @endif
        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-ghost">✏️ Editar</a>
        <a href="{{ route('usuarios.index') }}" class="btn btn-ghost">← Voltar</a>
    </div>
</div>

<div class="row g-4">
    <!-- Coluna da Esquerda: Resumo de Perfil e Contato -->
    <div class="col-lg-4">
        <div class="form-card h-100" style="max-width: 100%;">
            <div class="text-center mb-4">
                @php
                    $avatarBg = match($usuario->profile) {
                        'Admin' => 'rgba(16, 185, 129, 0.12)',
                        'Técnico' => 'rgba(59, 130, 246, 0.12)',
                        default => 'rgba(148, 163, 184, 0.12)'
                    };
                    $avatarColor = match($usuario->profile) {
                        'Admin' => 'var(--emerald)',
                        'Técnico' => 'var(--blue-400)',
                        default => 'var(--text-secondary)'
                    };
                @endphp
                <div class="d-inline-flex align-items-center justify-content-center fw-bold mb-3" style="width: 72px; height: 72px; border-radius: 50%; background-color: {{ $avatarBg }}; color: {{ $avatarColor }}; font-size: 26px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                    {{ strtoupper(substr($usuario->name, 0, 1)) }}
                </div>
                <h5 class="text-white mb-1" style="font-weight: 700;">{{ $usuario->name }}</h5>
                <span class="badge {{ $usuario->profile === 'Admin' ? 'badge-green' : 'badge-blue' }}">{{ $usuario->profile }}</span>
            </div>

            <hr style="border-color: var(--border); margin: 20px 0;">

            <div class="mb-3">
                <span class="d-block portal-label mb-1" style="font-size: 8.5px; color: var(--text-muted);">E-mail Cadastrado</span>
                <span class="font-mono text-light" style="font-size: 13px;">{{ $usuario->email }}</span>
            </div>

            <div class="mb-3">
                <span class="d-block portal-label mb-1" style="font-size: 8.5px; color: var(--text-muted);">Telefone / Ramal</span>
                <span class="font-mono text-light" style="font-size: 13px;">{{ $usuario->phone ?? '—' }}</span>
            </div>

            <div class="mb-3">
                <span class="d-block portal-label mb-1" style="font-size: 8.5px; color: var(--text-muted);">Situação da Conta</span>
                <div>
                    @php
                        $statusBadge = match($usuario->status) {
                            'Ativo' => 'badge-green',
                            'Pendente' => 'badge-amber',
                            'Rejeitado' => 'badge-rose',
                            default => 'badge-rose'
                        };
                    @endphp
                    <span class="badge {{ $statusBadge }}">{{ $usuario->status }}</span>
                </div>
            </div>

            <div class="mb-0">
                <span class="d-block portal-label mb-1" style="font-size: 8.5px; color: var(--text-muted);">Endereço</span>
                <span class="text-secondary small">{{ $usuario->address ?? '—' }}</span>
            </div>
        </div>
    </div>

    <!-- Coluna da Direita: Setor, Cargo e Permissões -->
    <div class="col-lg-8">
        
        <!-- Cartão de Vínculo Organizacional -->
        <div class="form-card mb-4" style="max-width: 100%;">
            <h5 class="text-white mb-3" style="font-size: 15px; font-weight: 700;">Estrutura Organizacional</h5>
            
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="p-3 rounded" style="background-color: var(--bg-850); border: 1px solid var(--border);">
                        <span class="d-block portal-label mb-1" style="font-size: 8px; color: var(--text-muted);">Setor / Departamento</span>
                        <span class="text-light fw-bold" style="font-size: 13px;">{{ $usuario->setor?->nome ?? '—' }}</span>
                        @if($usuario->setor?->descricao)
                            <p class="text-muted small mb-0 mt-1" style="font-size: 11px;">{{ $usuario->setor->descricao }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <div class="p-3 rounded" style="background-color: var(--bg-850); border: 1px solid var(--border);">
                        <span class="d-block portal-label mb-1" style="font-size: 8px; color: var(--text-muted);">Cargo / Função</span>
                        <span class="text-light fw-bold" style="font-size: 13px;">{{ $usuario->cargo?->nome ?? '—' }}</span>
                        @if($usuario->cargo?->descricao)
                            <p class="text-muted small mb-0 mt-1" style="font-size: 11px;">{{ $usuario->cargo->descricao }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-sm-6">
                    <div class="p-3 rounded" style="background-color: var(--bg-850); border: 1px solid var(--border);">
                        <span class="d-block portal-label mb-1" style="font-size: 8px; color: var(--text-muted);">Perfil Sistêmico (Role)</span>
                        <span class="text-light fw-bold" style="font-size: 13px;">{{ $usuario->accessRole?->name ?? 'Nenhum perfil associado' }}</span>
                        @if($usuario->accessRole?->description)
                            <p class="text-muted small mb-0 mt-1" style="font-size: 11px;">{{ $usuario->accessRole->description }}</p>
                        @endif
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="p-3 rounded" style="background-color: var(--bg-850); border: 1px solid var(--border);">
                        <span class="d-block portal-label mb-1" style="font-size: 8px; color: var(--text-muted);">Pergunta de Segurança</span>
                        <span class="text-light small fst-italic" style="font-size: 13px;">"{{ $usuario->security_question ?? 'Nenhuma cadastrada' }}"</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cartão de Permissões Ativas -->
        <div class="form-card" style="max-width: 100%;">
            <h5 class="text-white mb-2" style="font-size: 15px; font-weight: 700;">Chaves de Acesso e Permissões</h5>
            <p class="text-secondary small mb-3">Ações autorizadas para este colaborador de acordo com o seu perfil cadastrado:</p>
            
            @if($usuario->accessRole && $usuario->accessRole->permissions->isNotEmpty())
                <div class="perm-list">
                    @foreach($usuario->accessRole->permissions as $perm)
                        <span class="perm-chip d-flex align-items-center gap-1.5" style="cursor: default;">
                            🔑 {{ $perm->name }} <span class="text-muted" style="font-size: 9.5px;">({{ $perm->description }})</span>
                        </span>
                    @endforeach
                </div>
            @elseif($usuario->isAdmin())
                <div class="p-3 rounded text-success small" style="background-color: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.15);">
                    👑 **Acesso Irrestrito**: Este colaborador possui privilégios de Administrador Geral e possui todas as permissões habilitadas de forma automática.
                </div>
            @else
                <div class="p-3 rounded text-muted text-center small" style="background-color: var(--bg-850); border: 1px solid var(--border);">
                    ⚠️ Nenhuma permissão individual ou de perfil foi atribuída a este usuário ainda.
                </div>
            @endif
        </div>

    </div>
</div>

@endsection
