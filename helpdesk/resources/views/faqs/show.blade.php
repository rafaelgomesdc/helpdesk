@extends('layouts.app')
@section('title', 'FAQ')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">{{ $faq->pergunta }}</h1><p class="page-subtitle">{{ $faq->categoria?->nome }}</p></div>
    <a href="{{ route('faqs.index') }}" class="btn btn-ghost">Voltar</a>
</div>
<div class="form-card" style="max-width:100%;"><p style="line-height:1.7;color:var(--text-secondary);white-space:pre-wrap;">{{ $faq->resposta }}</p></div>
@endsection
