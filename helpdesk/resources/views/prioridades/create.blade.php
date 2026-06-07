@extends('layouts.app')
@section('title', 'Nova Prioridade')
@section('content')
<div class="page-header"><div><h1 class="page-title">Nova Prioridade</h1></div></div>
<div class="form-card">
    <form action="{{ route('prioridades.store') }}" method="POST">
        @csrf @include('prioridades._form')
        <div class="form-actions"><button class="btn btn-primary">Salvar</button><a href="{{ route('prioridades.index') }}" class="btn btn-ghost">Cancelar</a></div>
    </form>
</div>
@endsection
