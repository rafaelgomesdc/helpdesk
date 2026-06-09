<?php

// =============================================================================
//  ARTIGOS DA BASE DE CONHECIMENTO
//  Responsável: Dupla 2 — Gustavo e Rafael
//  Módulo: Abertura e Comunicação
// =============================================================================

namespace App\Http\Controllers;

use App\Models\Artigo;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtigoController extends Controller
{
    // -------------------------------------------------------------------------
    // Lista os artigos disponíveis na base de conhecimento
    // Opcionalmente filtra por categoria se o parâmetro for passado
    // -------------------------------------------------------------------------
    public function index(Request $request)
    {
        $query = Artigo::with(['categoria', 'autor']);

        // Filtro por categoria
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        $artigos = $query->orderByDesc('created_at')->get();
        $categorias = Categoria::orderBy('nome')->get();

        return view('artigos.index', compact('artigos', 'categorias'));
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário para criação de um novo artigo
    // -------------------------------------------------------------------------
    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('artigos.create', compact('categorias'));
    }

    // -------------------------------------------------------------------------
    // Salva o novo artigo na base de conhecimento
    // O autor é automaticamente preenchido com o usuário logado
    // -------------------------------------------------------------------------
    public function store(Request $request)
    {
        $dados = $request->validate([
            'titulo'       => 'required|max:255',
            'conteudo'     => 'required',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $dados['author_id'] = Auth::id();

        Artigo::create($dados);

        return redirect()->route('artigos.index')
            ->with('sucesso', 'Artigo publicado com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Exibe um artigo específico para leitura detalhada
    // -------------------------------------------------------------------------
    public function show(Artigo $artigo)
    {
        $artigo->load(['categoria', 'autor']);

        return view('artigos.show', compact('artigo'));
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de edição de um artigo existente
    // -------------------------------------------------------------------------
    public function edit(Artigo $artigo)
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('artigos.edit', compact('artigo', 'categorias'));
    }

    // -------------------------------------------------------------------------
    // Atualiza o conteúdo e as informações de um artigo
    // -------------------------------------------------------------------------
    public function update(Request $request, Artigo $artigo)
    {
        $dados = $request->validate([
            'titulo'       => 'required|max:255',
            'conteudo'     => 'required',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $artigo->update($dados);

        return redirect()->route('artigos.show', $artigo)
            ->with('sucesso', 'Artigo atualizado com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Remove permanentemente um artigo da base de conhecimento
    // -------------------------------------------------------------------------
    public function destroy(Artigo $artigo)
    {
        $artigo->delete();

        return redirect()->route('artigos.index')
            ->with('sucesso', 'Artigo removido com sucesso!');
    }
}
