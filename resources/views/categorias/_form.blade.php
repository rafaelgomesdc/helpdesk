@csrf
<div>
    <label>Nome</label><br>
    <input type="text" name="nome" value="{{ old('nome', $categoria->nome ?? '') }}">
    @error('nome') <div class="erro">{{ $message }}</div> @enderror
</div>
<div>
    <label>Descrição</label><br>
    <textarea name="descricao" rows="4">{{ old('descricao', $categoria->descricao ?? '') }}</textarea>
    @error('descricao') <div class="erro">{{ $message }}</div> @enderror
</div>