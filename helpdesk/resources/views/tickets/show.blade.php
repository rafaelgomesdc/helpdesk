@extends('layouts.app')
@section('title', 'Chamado #'.$ticket->id)
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">#{{ $ticket->id }} — {{ $ticket->title }}</h1>
        <p class="page-subtitle">{{ $ticket->categoria?->nome }} · {{ $ticket->priority_label }} · {{ $ticket->status_label }}</p>
    </div>
    <a href="{{ route('tickets.index') }}" class="btn btn-ghost">Voltar</a>
</div>

<div class="detail-grid" style="margin-bottom:24px;">
    <div class="detail-item"><div class="detail-label">Solicitante</div><div class="detail-value">{{ $ticket->user?->name }}</div></div>
    <div class="detail-item"><div class="detail-label">Técnico</div><div class="detail-value">{{ $ticket->technician?->name ?? 'Não atribuído' }}</div></div>
    <div class="detail-item"><div class="detail-label">Aberto em</div><div class="detail-value">{{ $ticket->created_at?->format('d/m/Y H:i') }}</div></div>
    <div class="detail-item"><div class="detail-label">Status</div><div class="detail-value">{{ $ticket->status_label }}</div></div>
</div>

<div class="form-card" style="max-width:100%; margin-bottom:24px;">
    <h3 style="margin-bottom:12px;font-size:15px;">Descrição</h3>
    <p style="color:var(--text-secondary);line-height:1.6;white-space:pre-wrap;">{{ $ticket->description }}</p>
    @if($ticket->solution)
        <h3 style="margin:20px 0 12px;font-size:15px;">Solução</h3>
        <p style="color:#34d399;line-height:1.6;white-space:pre-wrap;">{{ $ticket->solution }}</p>
    @endif
    @if($ticket->attachments->isNotEmpty())
        <h3 style="margin:20px 0 12px;font-size:15px;">Anexos</h3>
        <div class="perm-list">
            @foreach($ticket->attachments as $a)
                <a class="perm-chip" href="{{ asset('storage/'.$a->path) }}" target="_blank">{{ $a->filename }}</a>
            @endforeach
        </div>
    @endif
</div>

<div class="form-card" style="max-width:100%; margin-bottom:24px;">
    <h3 style="margin-bottom:16px;font-size:15px;">Comentários</h3>
    @forelse($ticket->comentarios as $c)
        <div style="padding:12px 0;border-bottom:1px solid var(--border);">
            <strong style="color:var(--text-primary);">{{ $c->user?->name }}</strong>
            <span style="font-size:11px;color:var(--text-muted);margin-left:8px;">{{ $c->created_at?->format('d/m/Y H:i') }}</span>
            <p style="margin-top:6px;color:var(--text-secondary);">{{ $c->conteudo }}</p>
        </div>
    @empty
        <p class="empty-text">Nenhum comentário ainda.</p>
    @endforelse
    <form action="{{ route('tickets.comentario.store', $ticket) }}" method="POST" style="margin-top:16px;">
        @csrf
        <div class="form-group" style="margin-bottom:12px;">
            <textarea name="conteudo" class="form-textarea" rows="3" placeholder="Escreva um comentário..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Enviar comentário</button>
    </form>
</div>

<div class="table-wrap">
    <div class="table-header"><span class="table-title">Histórico de atendimento</span></div>
    <div style="padding:20px;">
        @foreach($ticket->histories as $h)
            <div style="padding:10px 0;border-bottom:1px solid var(--border);">
                <strong style="color:var(--blue-400);">{{ $h->action }}</strong>
                <span style="font-size:11px;color:var(--text-muted);margin-left:8px;">{{ $h->created_at?->format('d/m/Y H:i') }}</span>
                <p style="margin-top:4px;color:var(--text-secondary);font-size:13px;">{{ $h->description }} — {{ $h->user?->name }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
