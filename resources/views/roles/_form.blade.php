<div class="form-group">
    <label class="form-label">Nome do perfil</label>
    <input type="text" name="name" class="form-input" value="{{ old('name', $role->name ?? '') }}" required>
    @error('name') <div class="form-error">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label class="form-label">Descrição</label>
    <textarea name="description" class="form-textarea">{{ old('description', $role->description ?? '') }}</textarea>
    @error('description') <div class="form-error">{{ $message }}</div> @enderror
</div>
@if(isset($permissions) && $permissions->isNotEmpty())
<div class="form-group">
    <label class="form-label">Permissões</label>
    <div class="perm-list">
        @foreach($permissions as $perm)
            <label class="perm-chip" style="cursor:pointer;">
                <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                    @checked(in_array($perm->id, old('permissions', isset($role) ? $role->permissions->pluck('id')->toArray() : [])))>
                {{ $perm->name }}
            </label>
        @endforeach
    </div>
</div>
@endif
