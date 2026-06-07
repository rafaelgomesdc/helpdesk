<?php

namespace App\Http\Controllers;

use App\Models\Artigo;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtigoController extends Controller
{
    public function index()
    {
        $artigos = Artigo::with(['categoria', 'autor'])->orderByDesc('created_at')->get();

        return view('artigos.index', compact('artigos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('artigos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $data['author_id'] = Auth::id();

        Artigo::create($data);

        return redirect()->route('artigos.index')->with('sucesso', 'Artigo publicado!');
    }

    public function show(Artigo $artigo)
    {
        $artigo->load(['categoria', 'autor']);

        return view('artigos.show', compact('artigo'));
    }

    public function edit(Artigo $artigo)
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('artigos.edit', compact('artigo', 'categorias'));
    }

    public function update(Request $request, Artigo $artigo)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $artigo->update($data);

        return redirect()->route('artigos.index')->with('sucesso', 'Artigo atualizado!');
    }

    public function destroy(Artigo $artigo)
    {
        $artigo->delete();

        return redirect()->route('artigos.index')->with('sucesso', 'Artigo removido!');
    }
}
