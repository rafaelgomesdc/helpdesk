<h1>Histórico do Chamado</h1>

<h2>{{ $ticket->title }}</h2>

<table border="1">

    <tr>
        <th>Ação</th>
        <th>Descrição</th>
        <th>Data</th>
    </tr>

    @foreach($ticket->histories as $history)

        <tr>
            <td>{{ $history->action }}</td>
            <td>{{ $history->description }}</td>
            <td>{{ $history->created_at }}</td>
        </tr>

    @endforeach

</table>    