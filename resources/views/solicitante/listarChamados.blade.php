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
                <td><button class="btn btn-primary">Ver</button></td>
            </tr>
            @foreach ($tickets as $t)
                <tr class="table-line">
                    <td>{{$c->id}}</td>
                    <td>{{$c->titulo}}</td>
                    <td>{{$c->prioridade}}</td>
                    <td>{{$c->status}}</td>
                    <td><button class="btn btn-primary">Ver</button></td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection