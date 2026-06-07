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
            <p class="mensagem enviada">{{$ticket->description}}</p>
            <p class="mensagem recebida">conteudo da resposta mais Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto beatae expedita consequuntur explicabo quam cupiditate voluptates alias quae deserunt? Obcaecati harum neque perferendis aut sapiente quibusdam totam officia aperiam temporibus? completa Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem deleniti est quos tempore alias facilis tenetur nam obcaecati, culpa et quaerat distinctio vitae eius architecto! Praesentium tempore vel deleniti eius.</p>
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