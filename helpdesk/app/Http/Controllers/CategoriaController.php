<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // LISTAR
    public function index()
    {
        $categorias = Categoria::orderBy('nome')->get();
        return view('categorias.index', compact('categorias'));
    }

    // FORM CRIAR
    public function create()
    {
        return view('categorias.create');
    }

    // SALVAR
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'      => ['required', 'min:2', 'max:100'],
            'descricao' => ['nullable', 'min:3'],
        ]);

        Categoria::create($dados);

        return redirect()->route('categorias.index')
            ->with('sucesso', 'Categoria cadastrada com sucesso!');
    }

    // FORM EDITAR
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    // ATUALIZAR
    public function update(Request $request, Categoria $categoria)
    {
        $dados = $request->validate([
            'nome'      => ['required', 'min:2', 'max:100'],
            'descricao' => ['nullable', 'min:3'],
        ]);

        $categoria->update($dados);

        return redirect()->route('categorias.index')
            ->with('sucesso', 'Categoria atualizada com sucesso!');
    }

    // EXCLUIR
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('sucesso', 'Categoria removida com sucesso!');
    }
}