@extends('layouts.app')
@section('title', 'Nova FAQ')
@section('content')
<div class="page-header"><div><h1 class="page-title">Nova FAQ</h1></div></div>
<div class="form-card"><form action="{{ route('faqs.store') }}" method="POST">@csrf @include('faqs._form')<div class="form-actions"><button class="btn btn-primary">Salvar</button><a href="{{ route('faqs.index') }}" class="btn btn-ghost">Cancelar</a></div></form></div>
@endsection
