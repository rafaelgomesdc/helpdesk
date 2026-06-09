<?php

// =============================================================================
//  CATEGORIAS DOS CHAMADOS
//  Responsável: Dupla 4 — Gabriel e Murilo
//  Módulo: Categorias, Prioridades, Dashboard e Base
// =============================================================================

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // -------------------------------------------------------------------------
    // Lista todas as categorias cadastradas em ordem alfabética
    // -------------------------------------------------------------------------
    public function index()
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('categorias.index', compact('categorias'));
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de criação de nova categoria
    // -------------------------------------------------------------------------
    public function create()
    {
        return view('categorias.create');
    }

    // -------------------------------------------------------------------------
    // Persiste a nova categoria no banco de dados
    // -------------------------------------------------------------------------
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'      => ['required', 'string', 'max:100', 'unique:categorias,nome'],
            'descricao' => ['nullable', 'string', 'max:255'],
        ]);

        Categoria::create($dados);

        return redirect()->route('categorias.index')
            ->with('sucesso', 'Categoria cadastrada com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de edição de uma categoria
    // -------------------------------------------------------------------------
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    // -------------------------------------------------------------------------
    // Atualiza os dados da categoria, ignorando o nome atual na verificação "unique"
    // -------------------------------------------------------------------------
    public function update(Request $request, Categoria $categoria)
    {
        $dados = $request->validate([
            'nome'      => ['required', 'string', 'max:100', 'unique:categorias,nome,'.$categoria->id],
            'descricao' => ['nullable', 'string', 'max:255'],
        ]);

        $categoria->update($dados);

        return redirect()->route('categorias.index')
            ->with('sucesso', 'Categoria atualizada com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Remove a categoria permanentemente
    // -------------------------------------------------------------------------
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('sucesso', 'Categoria removida com sucesso!');
    }
}
