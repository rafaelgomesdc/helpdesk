<?php

// =============================================================================
//  SETORES DA ORGANIZAÇÃO
//  Responsável: Dupla 3 — Paulo e Vitor
//  Módulo: Gerenciamento e Painel Técnico
// =============================================================================

namespace App\Http\Controllers;

use App\Models\Setor;
use Illuminate\Http\Request;

class SetorController extends Controller
{
    // -------------------------------------------------------------------------
    // Lista todos os setores com contagem de cargos e usuários vinculados
    // -------------------------------------------------------------------------
    public function index()
    {
        $setores = Setor::withCount('cargos', 'usuarios')->orderBy('nome')->get();

        return view('setores.index', compact('setores'));
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de criação de novo setor
    // -------------------------------------------------------------------------
    public function create()
    {
        return view('setores.create');
    }

    // -------------------------------------------------------------------------
    // Persiste um novo setor no banco de dados
    // O nome deve ser único para evitar duplicidade de setores
    // -------------------------------------------------------------------------
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'     => ['required', 'min:2', 'max:100', 'unique:setores,nome'],
            'descricao'=> ['nullable', 'max:255'],
        ]);

        Setor::create($dados);

        return redirect()->route('setores.index')
            ->with('sucesso', 'Setor cadastrado com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de edição de um setor existente
    // -------------------------------------------------------------------------
    public function edit(Setor $setor)
    {
        return view('setores.edit', compact('setor'));
    }

    // -------------------------------------------------------------------------
    // Atualiza os dados de um setor
    // Ignora o próprio nome ao verificar unicidade durante a edição
    // -------------------------------------------------------------------------
    public function update(Request $request, Setor $setor)
    {
        $dados = $request->validate([
            'nome'     => ['required', 'min:2', 'max:100', 'unique:setores,nome,'.$setor->id],
            'descricao'=> ['nullable', 'max:255'],
        ]);

        $setor->update($dados);

        return redirect()->route('setores.index')
            ->with('sucesso', 'Setor atualizado com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Remove um setor somente se não houver usuários vinculados a ele
    // Protege a integridade referencial dos dados
    // -------------------------------------------------------------------------
    public function destroy(Setor $setor)
    {
        if ($setor->usuarios()->exists()) {
            return back()->with('erro', 'Não é possível excluir: existem usuários vinculados a este setor.');
        }

        $setor->delete();

        return redirect()->route('setores.index')
            ->with('sucesso', 'Setor removido com sucesso!');
    }
}
