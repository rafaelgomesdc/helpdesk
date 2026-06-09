<?php

// =============================================================================
//  PERMISSÕES DO SISTEMA
//  Responsável: Dupla 4 — Gabriel e Murilo
//  Módulo: Categorias, Prioridades, Dashboard e Base
// =============================================================================

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    // -------------------------------------------------------------------------
    // Lista todas as permissões cadastradas com a contagem de perfis vinculados
    // -------------------------------------------------------------------------
    public function index()
    {
        $permissions = Permission::withCount('roles')->orderBy('name')->get();

        return view('permissions.index', compact('permissions'));
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de criação de nova permissão
    // -------------------------------------------------------------------------
    public function create()
    {
        return view('permissions.create');
    }

    // -------------------------------------------------------------------------
    // Persiste uma nova permissão no banco de dados
    // O nome deve ser único para evitar conflitos de autorização
    // -------------------------------------------------------------------------
    public function store(Request $request)
    {
        $dados = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:permissions,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Permission::create($dados);

        return redirect()->route('permissions.index')
            ->with('sucesso', 'Permissão cadastrada com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de edição de uma permissão existente
    // -------------------------------------------------------------------------
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    // -------------------------------------------------------------------------
    // Atualiza os dados de uma permissão
    // Ignora o próprio nome ao verificar unicidade durante a edição
    // -------------------------------------------------------------------------
    public function update(Request $request, Permission $permission)
    {
        $dados = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:permissions,name,'.$permission->id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $permission->update($dados);

        return redirect()->route('permissions.index')
            ->with('sucesso', 'Permissão atualizada com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Remove permanentemente uma permissão do sistema
    // -------------------------------------------------------------------------
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('sucesso', 'Permissão removida com sucesso!');
    }
}
