@extends('layouts.app')

@section('content')

<h1 class="page-title">Chamados Pendentes</h1>
<p class="subtitle">Lista de chamados aguardando atendimento.</p>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Solicitante</th>
                <th>Prioridade</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
            <tr>
                <td>#{{ $ticket->id }}</td>
                <td>{{ $ticket->title }}</td>
                <td>{{ $ticket->user->name }}</td>
                <td>
                    <span class="badge {{ $ticket->priority_badge_class }}">
                        {{ $ticket->priority_label }}
                    </span>
                </td>
                <td>
                    <form method="POST" action="{{ route('technician.assign', $ticket->id) }}">
                        @csrf
                        <button type="submit">Assumir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tickets->links() }}
</div>

@endsection
