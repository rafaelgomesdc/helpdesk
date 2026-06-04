@extends('layouts.app')

@section('content')

<h1 class="page-title">
    Chamados em Atendimento
</h1>

<p class="subtitle">
    Chamados atualmente em análise.
</p>

<div class="table-card">

<table>

    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Prioridade</th>
        </tr>
    </thead>

    <tbody>

    @foreach($tickets as $ticket)

        <tr>
            <td>#{{ $ticket->id }}</td>
            <td>{{ $ticket->title }}</td>
            <td>{{ $ticket->priority }}</td>
        </tr>

    @endforeach

    </tbody>

</table>

</div>

@endsection