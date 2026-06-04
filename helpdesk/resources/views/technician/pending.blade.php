@extends('layouts.app')

@section('content')

<h1 class="page-title">
    Chamados Pendentes
</h1>

<p class="subtitle">
    Lista de chamados aguardando atendimento.
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

            <td>

                @if($ticket->priority == 'Alta')
                    <span class="badge badge-high">
                        Alta
                    </span>

                @elseif($ticket->priority == 'Média')
                    <span class="badge badge-medium">
                        Média
                    </span>

                @else
                    <span class="badge badge-low">
                        Baixa
                    </span>
                @endif

            </td>

        </tr>

    @endforeach

    </tbody>

</table>

</div>

@endsection