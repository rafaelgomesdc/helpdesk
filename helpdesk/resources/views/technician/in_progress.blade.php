@extends('layouts.app')
@section('title', 'Em Atendimento')
@section('content')
<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Em Atendimento</h1>
        <p class="page-subtitle mb-0 text-secondary">Chamados em tratamento técnico por você</p>
    </div>
    <div class="d-flex gap-2">
        @if($tickets->count() > 0)
            <span class="badge badge-blue" style="font-size: 13px; padding: 8px 16px;">{{ $tickets->count() }} em andamento</span>
        @endif
        <a href="{{ route('technician.pending') }}" class="btn btn-ghost">Chamados Pendentes</a>
    </div>
</div>
@include('technician._table', ['tickets' => $tickets, 'action' => 'solution'])
@endsection
