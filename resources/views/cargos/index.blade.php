@extends('layouts.app')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Gerenciar Cargos</h2>
    <a href="{{ route('cargos.create') }}" class="btn btn-primary">+ Novo Cargo</a>
</div>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr><th>Nome</th><th>Descrição</th><th>Ações</th></tr>
            </thead>
            <tbody>
                @foreach($cargos as $c)
                <tr>
                    <td>{{ $c->nome }}</td>
                    <td>{{ $c->descricao ?? '-' }}</td>
                    <td>
                        <a href="{{ route('cargos.edit', $c) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                        <form method="POST" action="{{ route('cargos.destroy', $c) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir?')">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection