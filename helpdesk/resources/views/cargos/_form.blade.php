<div class="form-group">
    <label class="form-label">Nome do cargo</label>
    <input type="text" name="nome" class="form-input" value="{{ old('nome', $cargo->nome ?? '') }}" required>
    @error('nome') <div class="form-error">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label class="form-label">Setor</label>
    <select name="setor_id" class="form-select">
        <option value="">Nenhum</option>
        @foreach($setores as $s)
            <option value="{{ $s->id }}" @selected(old('setor_id', $cargo->setor_id ?? '') == $s->id)>{{ $s->nome }}</option>
        @endforeach
    </select>
    @error('setor_id') <div class="form-error">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label class="form-label">Descrição</label>
    <textarea name="descricao" class="form-textarea">{{ old('descricao', $cargo->descricao ?? '') }}</textarea>
    @error('descricao') <div class="form-error">{{ $message }}</div> @enderror
</div>
