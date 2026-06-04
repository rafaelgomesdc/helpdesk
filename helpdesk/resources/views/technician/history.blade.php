@extends('layouts.app')

@section('content')

<h1 class="page-title">
    Histórico do Chamado
</h1>

<p class="subtitle">
    {{ $ticket->title }}
</p>

<div class="table-card">

<table>

    <thead>
        <tr>
            <th>Ação</th>
            <th>Descrição</th>
            <th>Data</th>
        </tr>
    </thead>

    <tbody>

    @foreach($ticket->histories as $history)

        <tr>
            <td>{{ $history->action }}</td>
            <td>{{ $history->description }}</td>
            <td>{{ $history->created_at }}</td>
        </tr>

    @endforeach

    </tbody>

</table>

</div>

@endsection