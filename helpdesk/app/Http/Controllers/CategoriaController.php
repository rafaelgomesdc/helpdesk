<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
<<<<<<< HEAD
    // LISTAR
    public function index()
    {
        $categorias = Categoria::orderBy('nome')->get();
        return view('categorias.index', compact('categorias'));
    }

    // FORM CRIAR
=======
    public function index()
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('categorias.index', compact('categorias'));
    }

>>>>>>> UsuariosVitoria
    public function create()
    {
        return view('categorias.create');
    }

<<<<<<< HEAD
    // SALVAR
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'      => ['required', 'min:2', 'max:100'],
=======
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'min:2', 'max:100'],
>>>>>>> UsuariosVitoria
            'descricao' => ['nullable', 'min:3'],
        ]);

        Categoria::create($dados);

        return redirect()->route('categorias.index')
            ->with('sucesso', 'Categoria cadastrada com sucesso!');
    }

<<<<<<< HEAD
    // FORM EDITAR
=======
>>>>>>> UsuariosVitoria
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

<<<<<<< HEAD
    // ATUALIZAR
    public function update(Request $request, Categoria $categoria)
    {
        $dados = $request->validate([
            'nome'      => ['required', 'min:2', 'max:100'],
=======
    public function update(Request $request, Categoria $categoria)
    {
        $dados = $request->validate([
            'nome' => ['required', 'min:2', 'max:100'],
>>>>>>> UsuariosVitoria
            'descricao' => ['nullable', 'min:3'],
        ]);

        $categoria->update($dados);

        return redirect()->route('categorias.index')
            ->with('sucesso', 'Categoria atualizada com sucesso!');
    }

<<<<<<< HEAD
    // EXCLUIR
=======
>>>>>>> UsuariosVitoria
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('sucesso', 'Categoria removida com sucesso!');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> UsuariosVitoria
