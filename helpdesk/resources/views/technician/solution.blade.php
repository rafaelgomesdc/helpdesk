@extends('layouts.app')
@section('title', 'Registrar Solução')
@section('content')

<div class="page-header">
    <div><h1 class="page-title">Solução — #{{ $ticket->id }}</h1><p class="page-subtitle">{{ $ticket->title }}</p></div>
</div>

<div class="form-card">
    <form action="{{ route('technician.save-solution', $ticket) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">Descrição da solução</label>
            <textarea name="solution" class="form-textarea" rows="6" required minlength="10">{{ old('solution', $ticket->solution) }}</textarea>
            @error('solution') <div class="form-error">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label class="form-label">Status final</label>
            <select name="status" class="form-select">
                <option value="resolved">Resolvido</option>
                <option value="closed">Fechado</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Anexo da solução (opcional)</label>
            <input type="file" name="attachment" class="form-input">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar solução</button>
            <a href="{{ route('technician.in-progress') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
@endsection
