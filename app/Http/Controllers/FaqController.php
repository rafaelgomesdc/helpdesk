<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Categoria;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('categoria')->orderBy('created_at', 'desc')->get();

        return view('faqs.index', compact('faqs'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('faqs.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'pergunta'     => 'required|string',
            'resposta'     => 'required|string',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        Faq::create($dados);

        return redirect()->route('faqs.index')->with('sucesso', 'FAQ cadastrada com sucesso!');
    }

    public function show(Faq $faq)
    {
        return view('faqs.show', compact('faq'));
    }

    public function edit(Faq $faq)
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('faqs.edit', compact('faq', 'categorias'));
    }

    public function update(Request $request, Faq $faq)
    {
        $dados = $request->validate([
            'pergunta'     => 'required|string',
            'resposta'     => 'required|string',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $faq->update($dados);

        return redirect()->route('faqs.index')->with('sucesso', 'FAQ atualizada com sucesso!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faqs.index')->with('sucesso', 'FAQ removida com sucesso!');
    }
}
