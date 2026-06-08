@extends('layouts.app')
@section('title', 'Prioridades')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Prioridades</h1>
        <p class="page-subtitle">Gerencie os níveis de prioridade dos chamados</p>
    </div>
    <a href="{{ route('prioridades.create') }}" class="btn btn-primary">+ Nova Prioridade</a>
</div>

<div class="table-wrap">
    <div class="table-header">
        <span class="table-title">{{ $prioridades->count() }} prioridade(s) cadastrada(s)</span>
    </div>

    @if($prioridades->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🚦</div>
            <div class="empty-text">Nenhuma prioridade cadastrada ainda.</div>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Nível</th>
                    <th>Cor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prioridades as $prioridade)
                <tr>
                    <td>
                        <span style="display:inline-flex; align-items:center; gap:8px;">
                            <span style="width:10px; height:10px; border-radius:50%; background-color:{{ $prioridade->cor }};"></span>
                            <span style="font-weight:600; color:var(--text-primary);">{{ $prioridade->nome }}</span>
                        </span>
                    </td>
                    <td><span style="font-family:'IBM Plex Mono',monospace; font-size:12px;">{{ $prioridade->nivel }}</span></td>
                    <td>
                        <span style="display:inline-flex; align-items:center; gap:8px;">
                            <span style="width:20px; height:20px; border-radius:4px; background-color:{{ $prioridade->cor }}; border:1px solid var(--border);"></span>
                            <code style="font-family:'IBM Plex Mono',monospace; font-size:11px; color:var(--text-muted);">{{ $prioridade->cor }}</code>
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('prioridades.edit', $prioridade) }}" class="btn btn-ghost btn-sm">✏️ Editar</a>
                            <form method="POST" action="{{ route('prioridades.destroy', $prioridade) }}" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Excluir a prioridade \'{{ $prioridade->nome }}\'?')">🗑 Excluir</button>
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
