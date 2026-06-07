@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/listaChamados.css">
@endpush

@section('content')
    <h1>Seus chamados</h1>
    <div class="lista-chamados">
        <table>
            <tr class="table-title">
                <th>ID</th>
                <th>Título</th>
                <th>Prioridade</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            <tr class="table-line">
                <td>1</td>
                <td>Cancelamento de conta</td>
                <td>Alta</td>
                <td>Em aberto</td>
                <td><a class="btn btn-primary">Ver</a></td>
            </tr>
            @foreach ($tickets as $t)
                <tr class="table-line">
                    <td>{{$t->id}}</td>
                    <td>{{$t->title}}</td>
                    <td>{{$t->priority}}</td>
                    <td>{{$t->status}}</td>
                    <td><a class="btn btn-primary" href="{{ url('/ticketEspecifico/' . $t->id) }}">Ver</a></td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection