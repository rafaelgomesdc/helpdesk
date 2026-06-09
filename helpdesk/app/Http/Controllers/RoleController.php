<?php

// =============================================================================
//  PERFIS DE ACESSO (ROLES)
//  Responsável: Dupla 4 — Gabriel e Murilo
//  Módulo: Categorias, Prioridades, Dashboard e Base
// =============================================================================

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // -------------------------------------------------------------------------
    // Lista todos os perfis de acesso com a contagem de permissões vinculadas
    // -------------------------------------------------------------------------
    public function index()
    {
        $roles = Role::withCount('permissions')->orderBy('name')->get();

        return view('roles.index', compact('roles'));
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de criação de novo perfil
    // Carrega todas as permissões disponíveis para seleção
    // -------------------------------------------------------------------------
    public function create()
    {
        $permissions = Permission::orderBy('name')->get();

        return view('roles.create', compact('permissions'));
    }

    // -------------------------------------------------------------------------
    // Persiste o novo perfil e sincroniza suas permissões
    // -------------------------------------------------------------------------
    public function store(Request $request)
    {
        $dados = $request->validate([
            'name'          => ['required', 'string', 'max:100', 'unique:roles,name'],
            'description'   => ['nullable', 'string', 'max:255'],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role = Role::create([
            'name'        => $dados['name'],
            'description' => $dados['description'] ?? null,
        ]);

        // Sincroniza as permissões selecionadas com o perfil criado
        $role->permissions()->sync($dados['permissions'] ?? []);

        return redirect()->route('roles.index')
            ->with('sucesso', 'Perfil cadastrado com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de edição de um perfil com suas permissões atuais
    // -------------------------------------------------------------------------
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get();

        return view('roles.edit', compact('role', 'permissions'));
    }

    // -------------------------------------------------------------------------
    // Atualiza o perfil e ressincroniza as permissões selecionadas
    // -------------------------------------------------------------------------
    public function update(Request $request, Role $role)
    {
        $dados = $request->validate([
            'name'          => ['required', 'string', 'max:100', 'unique:roles,name,'.$role->id],
            'description'   => ['nullable', 'string', 'max:255'],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->update([
            'name'        => $dados['name'],
            'description' => $dados['description'] ?? null,
        ]);

        // Ressincroniza as permissões (remove as desmarcadas, adiciona as novas)
        $role->permissions()->sync($dados['permissions'] ?? []);

        return redirect()->route('roles.index')
            ->with('sucesso', 'Perfil atualizado com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Remove permanentemente um perfil de acesso
    // -------------------------------------------------------------------------
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('sucesso', 'Perfil removido com sucesso!');
    }
}
