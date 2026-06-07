<div class="form-group">
    <label class="form-label">Título</label>
    <input type="text" name="titulo" class="form-input" value="{{ old('titulo', $artigo->titulo ?? '') }}" required>
</div>
<div class="form-group">
    <label class="form-label">Categoria</label>
    <select name="categoria_id" class="form-select">
        <option value="">Nenhuma</option>
        @foreach($categorias as $c)
            <option value="{{ $c->id }}" @selected(old('categoria_id', $artigo->categoria_id ?? '')==$c->id)>{{ $c->nome }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label class="form-label">Conteúdo</label>
    <textarea name="conteudo" class="form-textarea" rows="10" required>{{ old('conteudo', $artigo->conteudo ?? '') }}</textarea>
</div>
