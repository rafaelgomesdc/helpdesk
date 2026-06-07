<div class="table-wrap">
    @if($tickets->isEmpty())
        <div class="empty-state"><div class="empty-icon">✅</div><div class="empty-text">Nenhum chamado nesta fila.</div></div>
    @else
        <table>
            <thead><tr><th>#</th><th>Título</th><th>Solicitante</th><th>Prioridade</th><th>Categoria</th><th>Ações</th></tr></thead>
            <tbody>
                @foreach($tickets as $t)
                <tr>
                    <td>#{{ $t->id }}</td>
                    <td style="font-weight:600;color:var(--text-primary);">{{ $t->title }}</td>
                    <td>{{ $t->user?->name }}</td>
                    <td><span class="badge badge-blue">{{ $t->priority_label }}</span></td>
                    <td>{{ $t->categoria?->nome ?? '—' }}</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('tickets.show', $t) }}" class="btn btn-ghost btn-sm">Ver</a>
                            @if(($action ?? '') === 'assign')
                                <form action="{{ route('technician.assign', $t) }}" method="POST" style="display:inline">@csrf<button class="btn btn-primary btn-sm">Assumir</button></form>
                            @else
                                <a href="{{ route('technician.solution', $t) }}" class="btn btn-primary btn-sm">Registrar solução</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:16px 20px;">{{ $tickets->links() }}</div>
    @endif
</div>
