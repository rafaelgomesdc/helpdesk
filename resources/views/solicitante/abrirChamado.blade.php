@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/aberturaChamados.css">
@endpush

@section('content')
    <h1>Abrir Chamado</h1>
    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="formAbrirChamado">
            <p>Título da solicitação</p>
            <input type="text" name="title" required>
            <div class="select">
                <div class="selectItem">
                    <p>Categoria</p>
                    <select name="categoria_id" required>
                        <option value="">Selecione a categoria</option>
                        @foreach($categorias as $c)
                            <option value={{ $c->id }}>{{ $c->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="selectItem">
                    <p>Prioridade</p>
                    <select name="priority" id="" required>
                        <option value="">Selecione o nível de prioridade</option>
                        <option value="high">opcao</option>
                        <option value="opcao">opcao</option>
                        <option value="opcao">opcao</option>
                    </select>
                </div>
            </div>
            <p>Descrição do problema</p>
            <textarea name="description" id="" cols="30" rows="5" required></textarea>
            <p>Anexos</p>
            <div class="anexos" id="anexos">
                <input type="file" name="anexoChamado" id="">
                <p class="desc">Selecione vários arquivos de uma vez segurando Ctrl.</p>
            </div>
            <div class="buttons">
                <a href="{{ route('tickets.index') }}" class="btn btn-ghost">Cancelar</a>
                <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </form>
@endsection