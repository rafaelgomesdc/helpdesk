<div class="form-group">
    <label class="form-label">Nome</label>
    <input type="text" name="nome" class="form-input" value="{{ old('nome', $prioridade->nome ?? '') }}" required>
    @error('nome') <div class="form-error">{{ $message }}</div> @enderror
</div>
<div class="form-grid">
    <div class="form-group">
        <label class="form-label">Nível (1-10)</label>
        <input type="number" name="nivel" class="form-input" min="1" max="10" value="{{ old('nivel', $prioridade->nivel ?? 1) }}" required>
    </div>
    <div class="form-group">
        <label class="form-label">Cor</label>
        <input type="color" name="cor" class="form-input" value="{{ old('cor', $prioridade->cor ?? '#6c757d') }}" required>
    </div>
</div>
