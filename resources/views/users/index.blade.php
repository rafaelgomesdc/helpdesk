@extends('layouts.app')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Gerenciar Usuários</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">+ Novo Usuário</a>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Contato</th>
                        <th>Endereço</th>
                        <th>Perfil</th>
                        <th>Cargo</th>
                        <th>Setor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->contato ?? '-' }}</td>
                        <td>{{ $u->endereco ?? '-' }}</td>
                        <td>
                            @if($u->role == 'admin') <span class="badge bg-danger">Admin</span>
                            @elseif($u->role == 'technician') <span class="badge bg-warning">Técnico</span>
                            @else <span class="badge bg-info">Usuário</span>
                            @endif
                        </td>
                        <td>{{ $u->cargo?->nome ?? '-' }}</td>
                        <td>{{ $u->setor?->nome ?? '-' }}</td>


                        <td>
                            <!-- Botão VER: Todos podem ver -->
                            <a href="{{ route('users.show', $u) }}" class="btn btn-sm btn-outline-primary">Ver</a>

                            @php
                                // Define quem PODE EDITAR este usuário específico
                                $podeEditar = false;

                                if (session('user_role') == 'admin') {
                                    // Admin pode editar QUALQUER um
                                    $podeEditar = true;
                                } 
                                elseif ( (session('user_role') == 'technician' || session('user_role') == 'user') && session('user_id') == $u->id ) {
                                    // Técnico e Usuário só editam ELES MESMOS
                                    $podeEditar = true;
                                }
                            @endphp

                            <!--  Botão EDITAR: Aparece apenas SE tiver permissão -->
                            @if($podeEditar)
                                <a href="{{ route('users.edit', $u) }}" class="btn btn-sm btn-outline-secondary ms-1">Editar</a>
                            @endif

                            <!--  Botão EXCLUIR: Aparece APENAS para ADMIN -->
                            @if(session('user_role') == 'admin')
                                <form method="POST" action="{{ route('users.destroy', $u) }}" class="d-inline ms-1">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                                </form>
                            @endif
                        </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection