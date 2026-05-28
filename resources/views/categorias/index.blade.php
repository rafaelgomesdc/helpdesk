@extends('layouts.app')
@section('title', 'Categorias')
@section('content')

    <h2>Categorias</h2>
    <a class="button" href="{{ route('categorias.create') }}">Nova Categoria</a>

    @if($categorias->isEmpty())
        <p>Nenhuma categoria cadastrada.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $c)
                <tr>
                    <td>{{ $c->nome }}</td>
                    <td>{{ $c->descricao ?? '—' }}</td>
                    <td>
                        <a class="button" href="{{ route('categorias.edit', $c) }}">Editar</a>
                        <form action="{{ route('categorias.destroy', $c) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Excluir esta categoria?')">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection