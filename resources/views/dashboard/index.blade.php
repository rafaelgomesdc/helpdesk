@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <h2>Dashboard</h2>

    <table>
        <thead>
            <tr>
                <th>Abertos</th>
                <th>Em Andamento</th>
                <th>Finalizados</th>
                <th>Tempo Médio</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $totalAbertos }}</td>
                <td>{{ $totalAndamento }}</td>
                <td>{{ $totalFinalizados }}</td>
                <td>{{ $tempoMedio }}h</td>
            </tr>
        </tbody>
    </table>

    <h3>Chamados por Categoria</h3>
    <table>
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Total de Chamados</th>
            </tr>
        </thead>
        <tbody>
            @foreach($porCategoria as $cat)
            <tr>
                <td>{{ $cat->nome }}</td>
                <td>{{ $cat->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection