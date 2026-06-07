@extends('layouts.app')
@section('title', 'Meus Chamados')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Chamados</h1>
        <p class="page-subtitle">{{ auth()->user()->role === 'user' ? 'Seus chamados abertos' : 'Todos os chamados' }}</p>
    </div>
    <a href="{{ route('tickets.create') }}" class="btn btn-primary">+ Abrir Chamado</a>
</div>

<div class="table-wrap">
    @if($tickets->isEmpty())
        <div class="empty-state"><div class="empty-icon">📋</div><div class="empty-text">Nenhum chamado encontrado.</div></div>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Prioridade</th>
                    <th>Status</th>
                    <th>Técnico</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $t)
                <tr>
                    <td>#{{ $t->id }}</td>
                    <td style="font-weight:600;color:var(--text-primary);">{{ $t->title }}</td>
                    <td>{{ $t->categoria?->nome ?? '—' }}</td>
                    <td><span class="badge badge-blue">{{ $t->priority_label }}</span></td>
                    <td>
                        @php $sb = match($t->status) { 'open'=>'badge-amber','in_progress'=>'badge-blue','resolved'=>'badge-green',default=>'badge-rose' }; @endphp
                        <span class="badge {{ $sb }}">{{ $t->status_label }}</span>
                    </td>
                    <td>{{ $t->technician?->name ?? '—' }}</td>
                    <td><a href="{{ route('tickets.show', $t) }}" class="btn btn-ghost btn-sm">Ver</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:16px 20px;">{{ $tickets->links() }}</div>
    @endif
</div>
@endsection
