<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use Illuminate\Http\Request;
//use App\Models\Chamados;

class SetorController extends Controller
{
    public function index()
    {
        $setores = Setor::orderBy('nome')->get();
        //$chamados = Chamados::all();
        return view('setores.index', compact('setores'));
    }

    public function create()
    {
        return view('setores.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255|unique:setores,nome',
            'descricao' => 'nullable|string'
        ]);

        Setor::create($dados);
        return redirect()->route('setores.index')->with('sucesso', 'Setor cadastrado!');
    }

    public function edit(Setor $setor)
    {
        return view('setores.edit', compact('setor'));
    }

    public function update(Request $request, Setor $setor)
    {
        $dados = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('setores', 'nome')->ignore($setor->id)
            ],
            'descricao' => 'nullable|string'
        ]);

        $setor->update($dados);
        return redirect()->route('setores.index')->with('sucesso', 'Setor atualizado!');
    }

    public function destroy(Setor $setor)
    {
        $setor->delete();
        return redirect()->route('setores.index')->with('sucesso', 'Setor removido!');
    }
}