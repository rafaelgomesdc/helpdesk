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
                <p class="id">Título</p>
                <p class="content">{{$ticket->title}}</p>
                <br>
                <p class="id">Categoria</p>
                <p class="content">{{$ticket->categoria_id}}</p>
            </div>
            <div class="right">
                <p class="id">Prioridade</p>
                <p class="content">{{$ticket->priority}}</p>
                <br>
                <p class="id">Status</p>
                <p class="content">{{$ticket->status}}</p>
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
        </div>
        <div class="caixa-mensagem">
            <form action="{{ route('tickets.comentario.store', $ticket->id) }}" method="POST">
                @csrf
                <textarea id="" name="conteudo"></textarea>
                <button class="btn btn-primary" type="submit">Enviar</button>
            </form>
        </div>
    </div>
@endsection