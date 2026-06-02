<h1>Chamados em Atendimento</h1>

<table border="1">

    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Prioridade</th>
    </tr>

    @foreach($tickets as $ticket)

        <tr>
            <td>{{ $ticket->id }}</td>
            <td>{{ $ticket->title }}</td>
            <td>{{ $ticket->priority }}</td>
        </tr>

    @endforeach

</table>