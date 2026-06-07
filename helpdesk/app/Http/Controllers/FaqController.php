<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('categoria')->orderByDesc('created_at')->get();

        return view('faqs.index', compact('faqs'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('faqs.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pergunta' => 'required|string',
            'resposta' => 'required|string',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        Faq::create($data);

        return redirect()->route('faqs.index')->with('sucesso', 'FAQ cadastrada!');
    }

    public function show(Faq $faq)
    {
        $faq->load('categoria');

        return view('faqs.show', compact('faq'));
    }

    public function edit(Faq $faq)
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('faqs.edit', compact('faq', 'categorias'));
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'pergunta' => 'required|string',
            'resposta' => 'required|string',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $faq->update($data);

        return redirect()->route('faqs.index')->with('sucesso', 'FAQ atualizada!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faqs.index')->with('sucesso', 'FAQ removida!');
    }
}
