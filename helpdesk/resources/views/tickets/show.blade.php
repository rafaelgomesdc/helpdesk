@extends('layouts.app')
@section('title', 'Chamado ' . $ticket->id)
@section('content')

<style>
    /* Estilos Locais da Linha do Tempo */
    .timeline {
        position: relative;
        padding-left: 32px;
        margin-top: 12px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        top: 12px;
        bottom: 12px;
        left: 7px;
        width: 2px;
        background: linear-gradient(180deg, var(--blue-600), var(--emerald));
        opacity: 0.3;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 24px;
    }
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    .timeline-dot {
        position: absolute;
        left: -32px;
        top: 6px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: var(--blue-500);
        border: 3px solid var(--bg-900);
        z-index: 2;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
    .timeline-item:nth-child(even) .timeline-dot {
        background: var(--emerald);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }
    .timeline-content {
        padding-left: 10px;
    }
    .timeline-date {
        font-size: 10px;
        color: var(--text-muted);
        display: block;
        margin-bottom: 3px;
        font-family: 'IBM Plex Mono', monospace;
    }
    .timeline-action {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-primary);
    }
    .timeline-desc {
        font-size: 12px;
        color: var(--text-secondary);
        margin-top: 4px;
        margin-bottom: 0;
        line-height: 1.5;
    }

    /* Estilos do Chat de Comentários */
    .chat-bubble {
        display: flex;
        gap: 16px;
        padding: 18px;
        border-radius: 12px;
        margin-bottom: 16px;
        border-left: 4px solid transparent;
        background-color: var(--bg-900);
        border: 1px solid var(--border);
        transition: all 0.2s ease;
    }
    .chat-bubble:hover {
        border-color: rgba(148, 163, 184, 0.15);
        transform: translateX(2px);
    }
    .chat-bubble.tech {
        border-left: 4px solid var(--blue-500) !important;
        background-color: rgba(59, 130, 246, 0.03);
    }
    .chat-bubble.admin {
        border-left: 4px solid var(--emerald) !important;
        background-color: rgba(16, 185, 129, 0.03);
    }
    .chat-bubble.user {
        border-left: 4px solid var(--text-muted) !important;
        background-color: rgba(148, 163, 184, 0.03);
    }
    .chat-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .chat-avatar.admin { background: linear-gradient(135deg, var(--emerald), #34d399); }
    .chat-avatar.tech { background: linear-gradient(135deg, var(--blue-600), var(--blue-400)); }
    .chat-avatar.user { background: linear-gradient(135deg, var(--bg-800), var(--bg-700)); }
    
    .chat-role-badge {
        font-size: 9px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .chat-role-badge.admin { background-color: rgba(16, 185, 129, 0.15); color: #34d399; }
    .chat-role-badge.tech { background-color: rgba(59, 130, 246, 0.15); color: #60a5fa; }
    .chat-role-badge.user { background-color: rgba(148, 163, 184, 0.15); color: #94a3b8; }

    /* Indicadores de prioridade */
    .priority-indicator {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .priority-indicator::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    .priority-low {
        background-color: rgba(96, 165, 250, 0.1);
        color: #60a5fa;
    }
    .priority-low::before { background-color: #60a5fa; }
    .priority-medium {
        background-color: rgba(252, 211, 77, 0.1);
        color: #fcd34d;
    }
    .priority-medium::before { background-color: #fcd34d; }
    .priority-high {
        background-color: rgba(251, 113, 129, 0.1);
        color: #fb7185;
    }
    .priority-high::before { background-color: #fb7185; }
    .priority-critical {
        background-color: rgba(244, 63, 94, 0.15);
        color: #f43f5e;
        animation: pulse 2s infinite;
    }
    .priority-critical::before { background-color: #f43f5e; }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
</style>

<div class="page-header d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
            <h1 class="page-title mb-0">{{ $ticket->id }} — {{ $ticket->title }}</h1>
            
            @php
                $statusClass = match($ticket->status) {
                    'open' => 'badge-amber',
                    'in_progress' => 'badge-blue',
                    'resolved' => 'badge-green',
                    'closed' => 'badge-green',
                    default => 'badge-rose'
                };
                $statusStyle = $ticket->status === 'closed' ? 'background-color: rgba(148, 163, 184, 0.15) !important; color: #cbd5e1 !important;' : '';
                
                $priorityClass = match($ticket->priority) {
                    'low' => 'priority-low',
                    'medium' => 'priority-medium',
                    'high' => 'priority-high',
                    'critical' => 'priority-critical',
                    default => 'priority-low'
                };
            @endphp
            <span class="badge {{ $statusClass }}" style="{{ $statusStyle }}">{{ $ticket->status_label }}</span>
            <span class="priority-indicator {{ $priorityClass }}">{{ $ticket->priority_label }}</span>
        </div>
        <p class="page-subtitle mb-0 text-secondary">
            Categoria: **{{ $ticket->categoria?->nome ?? 'Sem Categoria' }}** · Criado em: **{{ $ticket->created_at?->format('d/m/Y H:i') }}**
        </p>
    </div>
    
    <div class="d-flex gap-2">
        <!-- Ações do Técnico / Admin diretamente na visualização -->
        @if(in_array(auth()->user()->profile, ['Admin', 'Técnico']))
            @if($ticket->status === 'open')
                <form action="{{ route('technician.assign', $ticket) }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        👤 Assumir Chamado
                    </button>
                </form>
            @elseif($ticket->status === 'in_progress' && $ticket->technician_id === auth()->id())
                <a href="{{ route('technician.solution', $ticket) }}" class="btn btn-primary">
                    ✔️ Registrar Solução
                </a>
            @endif
        @endif
        <a href="{{ route('tickets.index') }}" class="btn btn-ghost">
            ← Voltar
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Bloco Esquerdo: Descrição e Solução -->
    <div class="col-lg-8">
        
        <!-- Detalhes do Chamado -->
        <div class="detail-grid mb-4">
            <div class="detail-item">
                <div class="detail-label">Solicitante</div>
                <div class="detail-value text-light">{{ $ticket->user?->name }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Técnico Responsável</div>
                <div class="detail-value">
                    @if($ticket->technician)
                        <span class="text-light">{{ $ticket->technician->name }}</span>
                    @else
                        <span class="text-warning small fst-italic">Aguardando Técnico</span>
                    @endif
                </div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Aberto Em</div>
                <div class="detail-value font-mono text-light">{{ $ticket->created_at?->format('d/m/Y H:i') }}</div>
            </div>
        </div>

        <!-- Descrição Principal -->
        <div class="form-card mb-4" style="max-width: 100%;">
            <h5 class="text-white mb-3" style="font-size: 15px; font-weight: 700; border-left: 3px solid var(--blue-600); padding-left: 10px;">Descrição do Problema</h5>
            <p class="text-secondary mb-0" style="line-height: 1.7; white-space: pre-wrap; font-size: 13.5px;">{{ $ticket->description }}</p>
        </div>

        <!-- Solução Registrada -->
        @if($ticket->solution)
            <div class="form-card mb-4" style="max-width: 100%; border: 1px solid rgba(16, 185, 129, 0.2); background-color: rgba(16, 185, 129, 0.01);">
                <h5 class="mb-3" style="font-size: 15px; font-weight: 700; color: #34d399; border-left: 3px solid var(--emerald); padding-left: 10px;">Solução Técnica Implementada</h5>
                <p class="mb-0 text-secondary" style="line-height: 1.7; white-space: pre-wrap; font-size: 13.5px;">{{ $ticket->solution }}</p>
                
                @if($ticket->resolved_at)
                    <div class="mt-3 text-muted small font-mono" style="font-size: 10.5px;">
                       Resolvido em: {{ \Carbon\Carbon::parse($ticket->resolved_at)->format('d/m/Y H:i') }}
                       
                    </div>
                @endif
            </div>
        @endif

        <!-- Anexos -->
        @if($ticket->attachments->isNotEmpty())
            <div class="form-card mb-4" style="max-width: 100%;">
                <h5 class="text-white mb-3" style="font-size: 14px; font-weight: 700;">Arquivos Anexados</h5>
                <div class="perm-list">
                    @foreach($ticket->attachments as $a)
                        <a class="perm-chip d-flex align-items-center gap-1.5" href="{{ asset('storage/' . $a->path) }}" target="_blank">
                            📎 {{ $a->filename }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Conversas e Comentários -->
        <div class="form-card mb-4" style="max-width: 100%;">
            <h5 class="text-white mb-4" style="font-size: 15px; font-weight: 700; border-left: 3px solid var(--blue-600); padding-left: 10px;">Diálogo de Atendimento</h5>
            
            <div class="chat-thread mb-4">
                @forelse($ticket->comentarios as $c)
                    @php
                        $userProfile = $c->user?->profile ?? 'Usuário';
                        $bubbleType = match($userProfile) {
                            'Admin' => 'admin',
                            'Técnico' => 'tech',
                            default => 'user'
                        };
                        $avatarClass = match($userProfile) {
                            'Admin' => 'admin',
                            'Técnico' => 'tech',
                            default => 'user'
                        };
                        $roleText = match($userProfile) {
                            'Admin' => 'Administrador',
                            'Técnico' => 'Técnico de Suporte',
                            default => 'Solicitante'
                        };
                    @endphp
                    <div class="chat-bubble {{ $bubbleType }}">
                        <!-- Avatar com as Iniciais -->
                        <div class="chat-avatar {{ $avatarClass }}">
                            {{ strtoupper(substr($c->user?->name ?? '?', 0, 2)) }}
                        </div>
                        
                        <!-- Conteúdo da Mensagem -->
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                <span class="fw-bold text-light" style="font-size: 13px;">{{ $c->user?->name }}</span>
                                <span class="chat-role-badge {{ $avatarClass }}">{{ $roleText }}</span>
                                <span class="text-muted font-mono" style="font-size: 10.5px; margin-left: auto;">{{ $c->created_at?->format('d/m/Y H:i') }}</span>
                            </div>
                            <p class="text-secondary small mb-0" style="line-height: 1.6; white-space: pre-wrap;">{{ $c->conteudo }}</p>
                        </div>
                    </div>
                @empty
                    <div class="empty-state text-center py-4">
                        <div class="empty-icon fs-4">💬</div>
                        <div class="empty-text text-muted small">Sem comentários registrados. Utilize o campo abaixo para enviar uma mensagem.</div>
                    </div>
                @endforelse
            </div>

            <!-- Formulário para novos comentários -->
            @if($ticket->status !== 'closed')
                <form action="{{ route('tickets.comentario.store', $ticket) }}" method="POST" class="border-top pt-4" style="border-color: var(--border) !important;">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Escrever Mensagem</label>
                        <textarea name="conteudo" class="form-textarea" rows="3" placeholder="Digite sua dúvida, atualização ou resposta técnica..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm">
                            💬 Enviar Mensagem
                        </button>
                    </div>
                </form>
            @else
                <div class="p-3 text-center rounded text-muted small" style="background-color: var(--bg-950); border: 1px solid var(--border);">
                    🔒 Chamado encerrado. Não é possível enviar novos comentários.
                </div>
            @endif
        </div>

    </div>

    <!-- Bloco Direito: Histórico e Ações Administrativas -->
    <div class="col-lg-4">
        
        <!-- Card do Histórico de Ações -->
        <div class="table-wrap mb-4">
            <div class="table-header">
                <span class="table-title">Histórico de Alterações</span>
            </div>
            
            <div style="padding: 20px;">
                <div class="timeline">
                    @forelse($ticket->histories as $h)
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <span class="timeline-date font-mono">{{ $h->created_at?->format('d/m/Y H:i') }}</span>
                                <div class="timeline-action">{{ $h->action }}</div>
                                <p class="timeline-desc">{{ $h->description }}</p>
                                <span class="text-muted font-mono" style="font-size: 10px;">Por: {{ $h->user?->name ?? 'Sistema' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state text-center py-3">
                            <div class="empty-text text-muted small">Nenhum evento registrado no histórico.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
