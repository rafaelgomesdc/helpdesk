@extends('layouts.app')
@section('title', 'Editar Setor')
@section('content')
<div class="page-header"><div><h1 class="page-title">Editar Setor</h1><p class="page-subtitle">{{ $setor->nome }}</p></div></div>
<div class="form-card">
    <form action="{{ route('setores.update', $setor) }}" method="POST">
        @csrf @method('PUT')
        @include('setores._form', ['setor' => $setor])
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('setores.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
@endsection
