@extends('layouts.app')
@section('title', 'Prioridades')
@section('content')
<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Prioridades</h1>
        <p class="page-subtitle mb-0 text-secondary">Níveis de prioridade dos chamados</p>
    </div>
    <a href="{{ route('prioridades.create') }}" class="btn btn-primary">➕ Nova</a>
</div>
<div class="table-wrap">
    @if($prioridades->isEmpty())
        <div class="empty-state py-5">
            <div class="empty-icon fs-2">🎯</div>
            <div class="empty-text text-muted mt-2">Nenhuma prioridade cadastrada.</div>
        </div>
    @else
        <div class="table-responsive">
            <table class="align-middle">
                <thead><tr><th style="width: 80px;">ID</th><th>Nome</th><th>Nível</th><th>Cor</th><th style="width: 200px; text-align: center;">Ações</th></tr></thead>
                <tbody>
                    @foreach($prioridades as $p)
                    <tr>
                        <td class="font-mono text-muted small">{{ $p->id }}</td>
                        <td><span class="badge" style="background:{{ $p->cor }};color:#fff;">{{ $p->nome }}</span></td>
                        <td>{{ $p->nivel }}</td>
                        <td><code class="small">{{ $p->cor }}</code></td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('prioridades.edit', $p) }}" class="btn btn-ghost btn-sm">✏️ Editar</a>
                                <form action="{{ route('prioridades.destroy', $p) }}" method="POST" style="margin: 0;">@csrf @method('DELETE')
                                    <button class="btn btn-ghost btn-sm" onclick="return confirm('Excluir?')">🗑 Excluir</button>
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
