<?php

// =============================================================================
//  PERGUNTAS FREQUENTES (FAQ)
//  Responsável: Dupla 2 — Gustavo e Rafael
//  Módulo: Abertura e Comunicação
// =============================================================================

namespace App\Http\Controllers;

use App\Models\Artigo;
use App\Models\Categoria;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // -------------------------------------------------------------------------
    // Lista todas as FAQs em conjunto com os Artigos da base de conhecimento
    // formando o portal de auto-atendimento unificado
    // Suporta filtro por categoria
    // -------------------------------------------------------------------------
    public function index(Request $request)
    {
        $query = Faq::with('categoria');

        // Filtro por categoria
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        $faqs = $query->orderBy('pergunta')->get();
        $categorias = Categoria::orderBy('nome')->get();

        return view('faqs.index', compact('faqs', 'categorias'));
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário para adicionar nova FAQ
    // -------------------------------------------------------------------------
    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('faqs.create', compact('categorias'));
    }

    // -------------------------------------------------------------------------
    // Persiste a nova FAQ no banco de dados
    // -------------------------------------------------------------------------
    public function store(Request $request)
    {
        $dados = $request->validate([
            'pergunta'     => 'required|max:255',
            'resposta'     => 'required',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        Faq::create($dados);

        return redirect()->route('faqs.index')->with('sucesso', 'FAQ adicionada com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Exibe os detalhes de uma FAQ específica (uso isolado, se necessário)
    // -------------------------------------------------------------------------
    public function show(Faq $faq)
    {
        return view('faqs.show', compact('faq'));
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de edição de uma FAQ existente
    // -------------------------------------------------------------------------
    public function edit(Faq $faq)
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('faqs.edit', compact('faq', 'categorias'));
    }

    // -------------------------------------------------------------------------
    // Atualiza as informações de uma FAQ
    // -------------------------------------------------------------------------
    public function update(Request $request, Faq $faq)
    {
        $dados = $request->validate([
            'pergunta'     => 'required|max:255',
            'resposta'     => 'required',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $faq->update($dados);

        return redirect()->route('faqs.index')->with('sucesso', 'FAQ atualizada com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Remove permanentemente uma FAQ
    // -------------------------------------------------------------------------
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faqs.index')->with('sucesso', 'FAQ removida com sucesso!');
    }
}
