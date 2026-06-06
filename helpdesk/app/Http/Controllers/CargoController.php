<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Setor;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index()
    {
        $cargos = Cargo::with('setor')->withCount('usuarios')->orderBy('nome')->get();

        return view('cargos.index', compact('cargos'));
    }

    public function create()
    {
        $setores = Setor::orderBy('nome')->get();

        return view('cargos.create', compact('setores'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'min:2', 'max:100'],
            'setor_id' => ['nullable', 'exists:setores,id'],
            'descricao' => ['nullable', 'max:255'],
        ]);

        Cargo::create($dados);

        return redirect()->route('cargos.index')
            ->with('sucesso', 'Cargo cadastrado com sucesso!');
    }

    public function edit(Cargo $cargo)
    {
        $setores = Setor::orderBy('nome')->get();

        return view('cargos.edit', compact('cargo', 'setores'));
    }

    public function update(Request $request, Cargo $cargo)
    {
        $dados = $request->validate([
            'nome' => ['required', 'min:2', 'max:100'],
            'setor_id' => ['nullable', 'exists:setores,id'],
            'descricao' => ['nullable', 'max:255'],
        ]);

        $cargo->update($dados);

        return redirect()->route('cargos.index')
            ->with('sucesso', 'Cargo atualizado com sucesso!');
    }

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
