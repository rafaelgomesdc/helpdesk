<div class="table-wrap">
    @if($tickets->isEmpty())
        <div class="empty-state py-5">
            <div class="empty-icon fs-2">✅</div>
            <div class="empty-text text-muted mt-2">Nenhum chamado nesta fila de atendimento.</div>
        </div>
    @else
        <div class="table-responsive">
            <table class="align-middle">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Título</th>
                        <th>Solicitante</th>
                        <th>Prioridade</th>
                        <th>Categoria</th>
                        <th style="width: 200px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $t)
                    <tr>
                        <td class="font-mono text-muted small">{{ $t->id }}</td>
                        <td style="font-weight:600; color:var(--text-primary);">{{ $t->title }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; border-radius: 50%; background-color: var(--bg-800); font-size: 10px; font-weight: 700; color: var(--text-secondary);">
                                    {{ strtoupper(substr($t->user?->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="small">{{ $t->user?->name ?? '—' }}</span>
                            </div>
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
                            <span class="text-secondary small">{{ $t->categoria?->nome ?? '—' }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('tickets.show', $t) }}" class="btn btn-ghost btn-sm">Ver Detalhes</a>
                                @if(($action ?? '') === 'assign')
                                    <form action="{{ route('technician.assign', $t) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button class="btn btn-primary btn-sm">Assumir</button>
                                    </form>
                                @else
                                    <a href="{{ route('technician.solution', $t) }}" class="btn btn-primary btn-sm">Solucionar</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($tickets->hasPages())
            <div class="border-top p-3 d-flex justify-content-center" style="border-color: var(--border) !important;">
                {{ $tickets->links() }}
            </div>
        @endif
    @endif
</div>
