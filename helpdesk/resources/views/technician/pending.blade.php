@extends('layouts.app')
@section('title', 'Chamados Pendentes')
@section('content')
<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Chamados Pendentes</h1>
        <p class="page-subtitle mb-0 text-secondary">Chamados aguardando atribuição de técnico</p>
    </div>
    <div class="d-flex gap-2">
        @if($tickets->count() > 0)
            <span class="badge badge-amber" style="font-size: 13px; padding: 8px 16px;">{{ $tickets->count() }} aguardando</span>
        @endif
        <a href="{{ route('technician.in-progress') }}" class="btn btn-ghost">Meus Chamados</a>
    </div>
</div>
@include('technician._table', ['tickets' => $tickets, 'action' => 'assign'])
@endsection
