<?php

// =============================================================================
//  CARGOS DOS USUÁRIOS
//  Responsável: Dupla 3 — Paulo e Vitor
//  Módulo: Gerenciamento e Painel Técnico
// =============================================================================

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Setor;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    // -------------------------------------------------------------------------
    // Lista todos os cargos com setor associado e contagem de usuários
    // -------------------------------------------------------------------------
    public function index()
    {
        $cargos = Cargo::with('setor')->withCount('usuarios')->orderBy('nome')->get();

        return view('cargos.index', compact('cargos'));
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de criação de novo cargo
    // Carrega os setores disponíveis para vinculação
    // -------------------------------------------------------------------------
    public function create()
    {
        $setores = Setor::orderBy('nome')->get();

        return view('cargos.create', compact('setores'));
    }

    // -------------------------------------------------------------------------
    // Persiste um novo cargo no banco de dados
    // O cargo pode estar ou não vinculado a um setor
    // -------------------------------------------------------------------------
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'     => ['required', 'min:2', 'max:100'],
            'setor_id' => ['nullable', 'exists:setores,id'],
            'descricao'=> ['nullable', 'max:255'],
        ]);

        Cargo::create($dados);

        return redirect()->route('cargos.index')
            ->with('sucesso', 'Cargo cadastrado com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de edição de um cargo existente
    // -------------------------------------------------------------------------
    public function edit(Cargo $cargo)
    {
        $setores = Setor::orderBy('nome')->get();

        return view('cargos.edit', compact('cargo', 'setores'));
    }

    // -------------------------------------------------------------------------
    // Atualiza os dados de um cargo
    // -------------------------------------------------------------------------
    public function update(Request $request, Cargo $cargo)
    {
        $dados = $request->validate([
            'nome'     => ['required', 'min:2', 'max:100'],
            'setor_id' => ['nullable', 'exists:setores,id'],
            'descricao'=> ['nullable', 'max:255'],
        ]);

        $cargo->update($dados);

        return redirect()->route('cargos.index')
            ->with('sucesso', 'Cargo atualizado com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Remove um cargo somente se não houver usuários vinculados a ele
    // Protege a integridade referencial dos dados
    // -------------------------------------------------------------------------
    public function destroy(Cargo $cargo)
    {
        if ($cargo->usuarios()->exists()) {
            return back()->with('erro', 'Não é possível excluir: existem usuários vinculados a este cargo.');
        }

        $cargo->delete();

        return redirect()->route('cargos.index')
            ->with('sucesso', 'Cargo removido com sucesso!');
    }
}
