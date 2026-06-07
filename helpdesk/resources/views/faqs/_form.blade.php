<div class="form-group">
    <label class="form-label">Pergunta</label>
    <input type="text" name="pergunta" class="form-input" value="{{ old('pergunta', $faq->pergunta ?? '') }}" required>
</div>
<div class="form-group">
    <label class="form-label">Resposta</label>
    <textarea name="resposta" class="form-textarea" rows="5" required>{{ old('resposta', $faq->resposta ?? '') }}</textarea>
</div>
<div class="form-group">
    <label class="form-label">Categoria</label>
    <select name="categoria_id" class="form-select">
        <option value="">Nenhuma</option>
        @foreach($categorias as $c)
            <option value="{{ $c->id }}" @selected(old('categoria_id', $faq->categoria_id ?? '')==$c->id)>{{ $c->nome }}</option>
        @endforeach
    </select>
</div>
