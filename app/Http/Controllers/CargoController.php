<?php
namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    // Lista todos os cargos
    public function index()
    {
        // Pega só os cargos, ordenados por nome
        $cargos = Cargo::orderBy('nome')->get();
        
        // Envia para a view correta: cargos.index
        return view('cargos.index', compact('cargos'));
    }

    // Mostra formulário de criação
    public function create()
    {
        // Não precisa de outras tabelas, só cria cargo
        return view('cargos.create');
    }

    // Salva novo cargo no banco
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255|unique:cargos,nome',
            'descricao' => 'nullable|string'
        ]);

        Cargo::create($dados);
        return redirect()->route('cargos.index')->with('sucesso', 'Cargo cadastrado com sucesso!');
    }

    // Mostra formulário de edição
    public function edit(Cargo $cargo)
    {
        return view('cargos.edit', compact('cargo'));
    }

    // Atualiza dados no banco
    public function update(Request $request, Cargo $cargo)
    {
        $dados = $request->validate([
           'nome' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('cargos', 'nome')->ignore($cargo->id)
            ],    
            //'descricao' => 'nullable|max:255',
            'descricao' => 'nullable|string'
        ]);

        $cargo->update($dados);
        return redirect()->route('cargos.index')->with('sucesso', 'Cargo atualizado com sucesso!');
    }

    // Exclui registro
    public function destroy(Cargo $cargo)
    {
        $cargo->delete();
        return redirect()->route('cargos.index')->with('sucesso', 'Cargo removido com sucesso!');
    }
}