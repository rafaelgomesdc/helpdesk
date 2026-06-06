@csrf
<div class="form-group">
    <label class="form-label">Nome da Categoria</label>
    <input type="text" name="nome" class="form-input"
        placeholder="Ex: Hardware, Software, Rede..."
        value="{{ old('nome', $categoria->nome ?? '') }}" autofocus>
    @error('nome') <div class="form-error">⚠ {{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label class="form-label">Descrição</label>
    <textarea name="descricao" class="form-textarea"
        placeholder="Descreva brevemente o tipo de chamados desta categoria...">{{ old('descricao', $categoria->descricao ?? '') }}</textarea>
    @error('descricao') <div class="form-error">⚠ {{ $message }}</div> @enderror
</div>
