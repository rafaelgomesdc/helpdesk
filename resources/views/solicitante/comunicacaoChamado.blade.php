@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/aberturaChamados.css">
@endpush

@section('content')
    <h1>Comunicação chamado</h1>
    <div class="conteudo-chamado">
        <p>Título: Cancelamento de conta</p>
        <p>Categoria: Outros</p>
        <p>Prioridade: Alta</p>
        <p>Status: Em aberto</p>
        <div class="chat">
            <p class="mensagem enviada">conteudo da mensagem</p>
            <p class="mensagem recebida">conteudo da resposta</p>
        </div>
    </div>
@endsection