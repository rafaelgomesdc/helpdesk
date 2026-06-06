@csrf
<div class="form-grid">
    <div class="form-group">
        <label class="form-label">Nome completo</label>
        <input type="text" name="name" class="form-input" value="{{ old('name', $usuario->name ?? '') }}" required>
        @error('name') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-input" value="{{ old('email', $usuario->email ?? '') }}" required>
        @error('email') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label class="form-label">Telefone</label>
        <input type="text" name="phone" class="form-input" placeholder="(11) 99999-9999"
            value="{{ old('phone', $usuario->phone ?? '') }}">
        @error('phone') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label class="form-label">Endereço</label>
        <input type="text" name="address" class="form-input" placeholder="Rua, número, bairro..."
            value="{{ old('address', $usuario->address ?? '') }}">
        @error('address') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label class="form-label">Setor</label>
        <select name="setor_id" class="form-select">
            <option value="">Selecione...</option>
            @foreach($setores as $s)
                <option value="{{ $s->id }}" @selected(old('setor_id', $usuario->setor_id ?? '') == $s->id)>{{ $s->nome }}</option>
            @endforeach
        </select>
        @error('setor_id') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label class="form-label">Cargo</label>
        <select name="cargo_id" class="form-select">
            <option value="">Selecione...</option>
            @foreach($cargos as $c)
                <option value="{{ $c->id }}" @selected(old('cargo_id', $usuario->cargo_id ?? '') == $c->id)>{{ $c->nome }}</option>
            @endforeach
        </select>
        @error('cargo_id') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label class="form-label">Perfil de acesso</label>
        <select name="profile" class="form-select" required>
            @foreach(['Admin', 'Técnico', 'Usuário'] as $p)
                <option value="{{ $p }}" @selected(old('profile', $usuario->profile ?? 'Usuário') == $p)>{{ $p }}</option>
            @endforeach
        </select>
        @error('profile') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label class="form-label">Perfil (Role)</label>
        <select name="role_id" class="form-select">
            <option value="">Nenhum</option>
            @foreach($roles as $r)
                <option value="{{ $r->id }}" @selected(old('role_id', $usuario->role_id ?? '') == $r->id)>{{ $r->name }}</option>
            @endforeach
        </select>
        @error('role_id') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            @foreach(['Ativo', 'Pendente', 'Rejeitado', 'Inativo'] as $st)
                <option value="{{ $st }}" @selected(old('status', $usuario->status ?? 'Ativo') == $st)>{{ $st }}</option>
            @endforeach
        </select>
        @error('status') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label class="form-label">Senha {{ isset($usuario) ? '(deixe em branco para manter)' : '' }}</label>
        <input type="password" name="password" class="form-input" {{ isset($usuario) ? '' : 'required' }} minlength="6">
        @error('password') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-group">
    <label class="form-label">Pergunta de segurança</label>
    <input type="text" name="security_question" class="form-input"
        value="{{ old('security_question', $usuario->security_question ?? '') }}">
    @error('security_question') <div class="form-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label class="form-label">Resposta de segurança {{ isset($usuario) ? '(deixe em branco para manter)' : '' }}</label>
    <input type="text" name="security_answer" class="form-input">
    @error('security_answer') <div class="form-error">{{ $message }}</div> @enderror
</div>
