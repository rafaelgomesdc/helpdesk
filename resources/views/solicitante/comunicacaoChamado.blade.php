@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/comunicacaoChamado.css">
@endpush

@section('content')
    <h1>Comunicação chamado</h1>
    <div class="conteudo-chamado">
        <div class="info">
            <div class="left">
                <p>Título: Cancelamento de conta</p>
                <p>Categoria: Outros</p>
            </div>
            <div class="right">
                <p>Prioridade: Alta</p>
                <p>Status: Em aberto</p>
            </div>
        </div>
        <div class="chat">
            <p class="mensagem enviada">conteudo da mensagem Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit facere dolorum adipisci non quos perferendis sequi ex odit harum accusantium error dicta iusto hic mollitia atque illo, excepturi ipsum magni. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eveniet dolorum cum atque reiciendis ex cumque incidunt repudiandae assumenda aspernatur. Earum dolor omnis tenetur amet obcaecati numquam iste repudiandae nam animi.</p>
            <p class="mensagem recebida">conteudo da resposta mais Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto beatae expedita consequuntur explicabo quam cupiditate voluptates alias quae deserunt? Obcaecati harum neque perferendis aut sapiente quibusdam totam officia aperiam temporibus? completa Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem deleniti est quos tempore alias facilis tenetur nam obcaecati, culpa et quaerat distinctio vitae eius architecto! Praesentium tempore vel deleniti eius.</p>
            <div class="caixa-mensagem">
                <form action="">
                    <textarea name="" id="" name="novaMensagem"></textarea>
                    <button>Enviar</button>
                </form>
            </div>
        </div>
    </div>
@endsection