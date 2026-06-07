@extends('layouts.app')
@section('title', 'Gerenciar Chamados')
@section('content')

<div class="page-header">
    <div><h1 class="page-title">Gerenciar Chamados</h1><p class="page-subtitle">Alterar status e atribuir técnicos</p></div>
</div>

<div class="table-wrap">
    <table>
        <thead><tr><th>#</th><th>Título</th><th>Status</th><th>Técnico</th><th>Atualizar</th></tr></thead>
        <tbody>
            @foreach($tickets as $t)
            <tr>
                <td>#{{ $t->id }}</td>
                <td><a href="{{ route('tickets.show', $t) }}" style="color:var(--blue-400);">{{ $t->title }}</a></td>
                <td>{{ $t->status_label }}</td>
                <td>{{ $t->technician?->name ?? '—' }}</td>
                <td>
                    <form action="{{ route('technician.update-status', $t) }}" method="POST" style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
                        @csrf
                        <select name="status" class="form-select" style="width:auto;min-width:130px;">
                            @foreach(\App\Models\Ticket::STATUS_LABELS as $k => $v)
                                <option value="{{ $k }}" @selected($t->status==$k)>{{ $v }}</option>
                            @endforeach
                        </select>
                        <select name="technician_id" class="form-select" style="width:auto;min-width:150px;">
                            <option value="">Técnico...</option>
                            @foreach($tecnicos as $tec)
                                <option value="{{ $tec->id }}" @selected($t->technician_id==$tec->id)>{{ $tec->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary btn-sm">Salvar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding:16px 20px;">{{ $tickets->links() }}</div>
</div>
@endsection
