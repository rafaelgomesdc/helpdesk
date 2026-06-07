@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/comunicacaoChamado.css">
@endpush

@section('content')
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <h1>Comunicação chamado</h1>
    <div class="conteudo-chamado">
        <div class="info">
            <div class="left">
                <p>Título: {{$ticket->title}}</p>
                <p>Categoria: {{$ticket->categoria_id}}</p>
            </div>
            <div class="right">
                <p>Prioridade: {{$ticket->priority}}</p>
                <p>Status: {{$ticket->status}}</p>
            </div>
        </div>
        <div class="chat">
            <!--Primeira mensagem (descricao)*/-->
            @if ($ticket->user_id === Auth::id())
                <p class="mensagem enviada">{{$ticket->description}}</p>
            @else
                <p class="mensagem recebida">{{$ticket->description}}</p>
            @endif
            <!--Mensagens (comentarios)-->
            @foreach ($comentarios as $c)
                @if ($c->user_id === Auth::id())
                    <p class="mensagem enviada">{{$c->conteudo}}</p>
                @else
                    <p class="mensagem recebida">{{$c->conteudo}}</p>
                @endif
            @endforeach
            <div class="caixa-mensagem">
                <form action="{{ route('tickets.comentario.store', $ticket->id) }}" method="POST">
                    @csrf
                    <textarea id="" name="conteudo"></textarea>
                    <button type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>
@endsection