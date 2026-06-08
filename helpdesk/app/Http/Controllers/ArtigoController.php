<?php

namespace App\Http\Controllers;

use App\Models\Artigo;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ArtigoController extends Controller
{
    public function index()
    {
        $artigos = Artigo::with(['categoria', 'autor'])->orderBy('created_at', 'desc')->get();

        return view('artigos.index', compact('artigos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('artigos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'titulo'       => 'required|string|max:255',
            'conteudo'     => 'required|string',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $dados['author_id'] = auth()->id();

        Artigo::create($dados);

        return redirect()->route('artigos.index')->with('sucesso', 'Artigo publicado com sucesso!');
    }

    public function show(Artigo $artigo)
    {
        return view('artigos.show', compact('artigo'));
    }

    public function edit(Artigo $artigo)
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('artigos.edit', compact('artigo', 'categorias'));
    }

    public function update(Request $request, Artigo $artigo)
    {
        $dados = $request->validate([
            'titulo'       => 'required|string|max:255',
            'conteudo'     => 'required|string',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $artigo->update($dados);

        return redirect()->route('artigos.index')->with('sucesso', 'Artigo atualizado com sucesso!');
    }

    public function destroy(Artigo $artigo)
    {
        $artigo->delete();

        return redirect()->route('artigos.index')->with('sucesso', 'Artigo removido com sucesso!');
    }
}
