<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use Illuminate\Http\Request;

class SetorController extends Controller
{
    public function index()
    {
        $setores = Setor::withCount('cargos', 'usuarios')->orderBy('nome')->get();

        return view('setores.index', compact('setores'));
    }

    public function create()
    {
        return view('setores.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'min:2', 'max:100', 'unique:setores,nome'],
            'descricao' => ['nullable', 'max:255'],
        ]);

        Setor::create($dados);

        return redirect()->route('setores.index')
            ->with('sucesso', 'Setor cadastrado com sucesso!');
    }

    public function edit(Setor $setor)
    {
        return view('setores.edit', compact('setor'));
    }

    public function update(Request $request, Setor $setor)
    {
        $dados = $request->validate([
            'nome' => ['required', 'min:2', 'max:100', 'unique:setores,nome,'.$setor->id],
            'descricao' => ['nullable', 'max:255'],
        ]);

        $setor->update($dados);

        return redirect()->route('setores.index')
            ->with('sucesso', 'Setor atualizado com sucesso!');
    }

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
