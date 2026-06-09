@extends('layouts.app')
@section('title', 'Registrar Solução')
@section('content')

<div class="page-header mb-4">
    <div>
        <h1 class="page-title mb-1">Registrar Solução — {{ $ticket->id }}</h1>
        <p class="page-subtitle mb-0 text-secondary">{{ $ticket->title }}</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="form-card">
            <form action="{{ route('technician.save-solution', $ticket) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-4">
                    <label class="form-label">Descrição da Solução</label>
                    <textarea name="solution" class="form-textarea" rows="8" required minlength="10" placeholder="Descreva os passos realizados, configurações alteradas, ou ações tomadas para resolver o problema...">{{ old('solution', $ticket->solution) }}</textarea>
                    @error('solution') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Status Final</label>
                    <select name="status" class="form-select">
                        <option value="resolved" @selected(old('status') === 'resolved')>✅ Resolvido (aguarda confirmação do usuário)</option>
                        <option value="closed" @selected(old('status') === 'closed')">🔒 Fechado (solução confirmada)</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Anexo da Solução (opcional)</label>
                    <div class="p-3 rounded" style="background: var(--bg-850); border: 1px solid var(--border);">
                        <input type="file" name="attachment" class="form-input" accept="image/*,.pdf,.doc,.docx" style="background-color: var(--bg-900); color: var(--text-secondary);">
                        <div class="text-muted small mt-2" style="font-size: 11px;">Você pode anexar capturas de tela, logs ou documentos que comprovem a solução.</div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">💾 Salvar Solução</button>
                    <a href="{{ route('technician.in-progress') }}" class="btn btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-card">
            <h5 class="text-white mb-3" style="font-size: 14px; font-weight: 700;">Detalhes do Chamado</h5>
            
            <div class="mb-3">
                <span class="d-block text-muted small mb-1">Solicitante</span>
                <span class="text-light">{{ $ticket->user?->name ?? '—' }}</span>
            </div>

            <div class="mb-3">
                <span class="d-block text-muted small mb-1">Categoria</span>
                <span class="badge badge-blue">{{ $ticket->categoria?->nome ?? '—' }}</span>
            </div>

            <div class="mb-3">
                <span class="d-block text-muted small mb-1">Prioridade</span>
                @php
                    $prioClass = match($ticket->priority) {
                        'low' => 'badge-blue',
                        'medium' => 'badge-amber',
                        'high' => 'badge-rose',
                        'critical' => 'badge-rose',
                        default => 'badge-blue'
                    };
                @endphp
                <span class="badge {{ $prioClass }}">{{ $ticket->priority_label }}</span>
            </div>

            <div class="mb-0">
                <span class="d-block text-muted small mb-1">Descrição Original</span>
                <p class="text-secondary small" style="line-height: 1.5;">{{ $ticket->description }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
