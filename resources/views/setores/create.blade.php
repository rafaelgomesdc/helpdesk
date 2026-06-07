@extends('layouts.app')
@section('title', 'Novo Setor')
@section('content')
<div class="page-header"><div><h1 class="page-title">Novo Setor</h1></div></div>
<div class="form-card">
    <form action="{{ route('setores.store') }}" method="POST">
        @csrf
        @include('setores._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('setores.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
@endsection
