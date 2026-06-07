@extends('layouts.app')
@section('title', 'Editar Prioridade')
@section('content')
<div class="page-header"><div><h1 class="page-title">Editar Prioridade</h1></div></div>
<div class="form-card">
    <form action="{{ route('prioridades.update', $prioridade) }}" method="POST">
        @csrf @method('PUT') @include('prioridades._form', ['prioridade' => $prioridade])
        <div class="form-actions"><button class="btn btn-primary">Atualizar</button><a href="{{ route('prioridades.index') }}" class="btn btn-ghost">Cancelar</a></div>
    </form>
</div>
@endsection
