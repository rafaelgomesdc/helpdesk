@extends('layouts.app')
@section('title', 'Prioridades')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Prioridades</h1><p class="page-subtitle">Níveis de prioridade dos chamados</p></div>
    <a href="{{ route('prioridades.create') }}" class="btn btn-primary">+ Nova</a>
</div>
<div class="table-wrap">
    <table>
        <thead><tr><th>Nome</th><th>Nível</th><th>Cor</th><th>Ações</th></tr></thead>
        <tbody>
            @forelse($prioridades as $p)
            <tr>
                <td><span class="badge" style="background:{{ $p->cor }};color:#fff;">{{ $p->nome }}</span></td>
                <td>{{ $p->nivel }}</td>
                <td><code>{{ $p->cor }}</code></td>
                <td>
                    <a href="{{ route('prioridades.edit', $p) }}" class="btn btn-ghost btn-sm">Editar</a>
                    <form action="{{ route('prioridades.destroy', $p) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Excluir?')">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="empty-text">Nenhuma prioridade cadastrada.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
