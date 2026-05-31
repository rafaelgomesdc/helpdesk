@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Cadastrar Novo Usuário</h2>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nome Completo</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contato</label>
                    <input type="text" name="contato" class="form-control" value="{{ old('contato') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Endereço</label>
                <input type="text" name="endereco" class="form-control" value="{{ old('endereco') }}">
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Perfil</label>
                    <select name="role" class="form-select" required>
                        <option value="user" {{ old('role')=='user'?'selected':'' }}>Usuário</option>
                        <option value="technician" {{ old('role')=='technician'?'selected':'' }}>Técnico</option>
                        <option value="admin" {{ old('role')=='admin'?'selected':'' }}>Administrador</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Cargo</label>
                    <select name="cargo_id" class="form-select" required>
                        <option value="">Selecione...</option>
                        @foreach($cargos as $c)
                            <option value="{{ $c->id }}" {{ old('cargo_id')==$c->id?'selected':'' }}>{{ $c->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Setor</label>
                    <select name="setor_id" class="form-select" required>
                        <option value="">Selecione...</option>
                        @foreach($setores as $s)
                            <option value="{{ $s->id }}" {{ old('setor_id')==$s->id?'selected':'' }}>{{ $s->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection