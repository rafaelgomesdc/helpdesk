<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::withCount('roles')->orderBy('name')->get();

        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:permissions,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Permission::create($dados);

        return redirect()->route('permissions.index')
            ->with('sucesso', 'Permissão cadastrada com sucesso!');
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:permissions,name,'.$permission->id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $permission->update($dados);

        return redirect()->route('permissions.index')
            ->with('sucesso', 'Permissão atualizada com sucesso!');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('sucesso', 'Permissão removida com sucesso!');
    }
}
