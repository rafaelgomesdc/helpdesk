@extends('layouts.app')
@section('title', 'Editar Cargo')
@section('content')
<div class="page-header"><div><h1 class="page-title">Editar Cargo</h1><p class="page-subtitle">{{ $cargo->nome }}</p></div></div>
<div class="form-card">
    <form action="{{ route('cargos.update', $cargo) }}" method="POST">
        @csrf @method('PUT')
        @include('cargos._form', ['cargo' => $cargo])
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('cargos.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
@endsection
