@extends('layouts.app')
@section('title', 'Nova Permissão')
@section('content')
<div class="page-header"><div><h1 class="page-title">Nova Permissão</h1></div></div>
<div class="form-card">
    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        @include('permissions._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('permissions.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
@endsection
