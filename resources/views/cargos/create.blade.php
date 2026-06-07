@extends('layouts.app')
@section('title', 'Novo Cargo')
@section('content')
<div class="page-header"><div><h1 class="page-title">Novo Cargo</h1></div></div>
<div class="form-card">
    <form action="{{ route('cargos.store') }}" method="POST">
        @csrf
        @include('cargos._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('cargos.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
@endsection
