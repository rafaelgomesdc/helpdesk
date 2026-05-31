@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Detalhes do Usuário</h2>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th>Nome:</th><td>{{ $user->name }}</td></tr>
            <tr><th>E-mail:</th><td>{{ $user->email }}</td></tr>
            <tr><th>Contato:</th><td>{{ $user->contato ?? 'Não informado' }}</td></tr>
            <tr><th>Endereço:</th><td>{{ $user->endereco ?? 'Não informado' }}</td></tr>
            <tr><th>Perfil:</th><td>
                @if($user->role == 'admin') Administrador
                @elseif($user->role == 'technician') Técnico
                @else Usuário @endif
            </td></tr>
            <tr><th>Cargo:</th><td>{{ $user->cargo?->nome ?? '-' }}</td></tr>
            <tr><th>Setor:</th><td>{{ $user->setor?->nome ?? '-' }}</td></tr>
            <tr><th>Cadastrado em:</th><td>{{ $user->created_at->format('d/m/Y H:i') }}</td></tr>
        </table>

        <div class="mt-4">
            @php
                $podeEditar = false;
                if (session('user_role') == 'admin' || session('user_id') == $user->id) {
                    $podeEditar = true;
                }
            @endphp

            @if($podeEditar)
                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Editar Meus Dados</a>
            @endif

            <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">
                Voltar
            </a>
        </div>
        

    </div>
</div>
@endsection