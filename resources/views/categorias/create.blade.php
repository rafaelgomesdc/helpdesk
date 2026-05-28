@extends('layouts.app')
@section('title', 'Nova Categoria')
@section('content')

    <h2>Cadastrar Categoria</h2>
    <form action="{{ route('categorias.store') }}" method="POST">
        @include('categorias._form')
        <button type="submit">Salvar</button>
        <a class="button" href="{{ route('categorias.index') }}">Cancelar</a>
    </form>

@endsection