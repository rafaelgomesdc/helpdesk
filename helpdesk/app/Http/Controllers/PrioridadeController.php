<?php

namespace App\Http\Controllers;

use App\Models\Prioridade;
use Illuminate\Http\Request;

class PrioridadeController extends Controller
{
    public function index()
    {
        $prioridades = Prioridade::orderBy('nivel')->get();

        return view('prioridades.index', compact('prioridades'));
    }

    public function create()
    {
        return view('prioridades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'  => 'required|string|max:50|unique:prioridades,nome',
            'nivel' => 'required|integer|min:1|max:10',
            'cor'   => 'required|string|max:20',
        ], [
            'nome.required'  => 'O nome da prioridade é obrigatório.',
            'nome.unique'    => 'Já existe uma prioridade com este nome.',
            'nivel.required' => 'O nível é obrigatório.',
            'nivel.min'      => 'O nível mínimo é 1.',
            'nivel.max'      => 'O nível máximo é 10.',
            'cor.required'   => 'A cor é obrigatória.',
        ]);

        Prioridade::create($request->only(['nome', 'nivel', 'cor']));

        return redirect()->route('prioridades.index')
            ->with('sucesso', 'Prioridade criada com sucesso.');
    }

    public function edit(Prioridade $prioridade)
    {
        return view('prioridades.edit', compact('prioridade'));
    }

    public function update(Request $request, Prioridade $prioridade)
    {
        $request->validate([
            'nome'  => 'required|string|max:50|unique:prioridades,nome,' . $prioridade->id,
            'nivel' => 'required|integer|min:1|max:10',
            'cor'   => 'required|string|max:20',
        ], [
            'nome.required'  => 'O nome da prioridade é obrigatório.',
            'nome.unique'    => 'Já existe uma prioridade com este nome.',
            'nivel.required' => 'O nível é obrigatório.',
            'cor.required'   => 'A cor é obrigatória.',
        ]);

        $prioridade->update($request->only(['nome', 'nivel', 'cor']));

        return redirect()->route('prioridades.index')
            ->with('sucesso', 'Prioridade atualizada com sucesso.');
    }

    public function destroy(Prioridade $prioridade)
    {
        $prioridade->delete();

        return redirect()->route('prioridades.index')
            ->with('sucesso', 'Prioridade excluída com sucesso.');
    }
}
