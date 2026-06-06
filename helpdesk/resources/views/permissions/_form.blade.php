<div class="form-group">
    <label class="form-label">Nome da permissão</label>
    <input type="text" name="name" class="form-input" placeholder="Ex: usuarios.criar"
        value="{{ old('name', $permission->name ?? '') }}" required>
    @error('name') <div class="form-error">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label class="form-label">Descrição</label>
    <textarea name="description" class="form-textarea">{{ old('description', $permission->description ?? '') }}</textarea>
    @error('description') <div class="form-error">{{ $message }}</div> @enderror
</div>
