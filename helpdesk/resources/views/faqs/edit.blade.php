@extends('layouts.app')
@section('title', 'Editar FAQ')
@section('content')
<div class="page-header"><div><h1 class="page-title">Editar FAQ</h1></div></div>
<div class="form-card"><form action="{{ route('faqs.update', $faq) }}" method="POST">@csrf @method('PUT') @include('faqs._form', ['faq'=>$faq])<div class="form-actions"><button class="btn btn-primary">Atualizar</button><a href="{{ route('faqs.index') }}" class="btn btn-ghost">Cancelar</a></div></form></div>
@endsection
