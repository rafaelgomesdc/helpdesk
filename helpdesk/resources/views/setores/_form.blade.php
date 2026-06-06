<div class="form-group">
    <label class="form-label">Nome do setor</label>
    <input type="text" name="nome" class="form-input" value="{{ old('nome', $setor->nome ?? '') }}" required>
    @error('nome') <div class="form-error">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label class="form-label">Descrição</label>
    <textarea name="descricao" class="form-textarea">{{ old('descricao', $setor->descricao ?? '') }}</textarea>
    @error('descricao') <div class="form-error">{{ $message }}</div> @enderror
</div>
