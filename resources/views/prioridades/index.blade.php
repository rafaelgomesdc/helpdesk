@extends('layouts.app')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Gerenciar Prioridades</h2>
    <a href="{{ route('prioridades.create') }}" class="btn btn-primary">+ Nova Prioridade</a>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Nível</th>
                        <th>Cor</th>
                        <th width="180">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prioridades as $prioridade)
                    <tr>
                        <td>
                            <span class="badge"
                                  style="background-color: {{ $prioridade->cor }}; color: #fff; font-size: 0.9em;">
                                {{ $prioridade->nome }}
                            </span>
                        </td>
                        <td>{{ $prioridade->nivel }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span style="display:inline-block; width:24px; height:24px;
                                             border-radius:4px; background-color:{{ $prioridade->cor }};
                                             border:1px solid #ccc;"></span>
                                <code>{{ $prioridade->cor }}</code>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('prioridades.edit', $prioridade) }}"
                               class="btn btn-sm btn-outline-secondary">Editar</a>
                            <form method="POST"
                                  action="{{ route('prioridades.destroy', $prioridade) }}"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Deseja excluir a prioridade \'{{ $prioridade->nome }}\'?')">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            Nenhuma prioridade cadastrada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
