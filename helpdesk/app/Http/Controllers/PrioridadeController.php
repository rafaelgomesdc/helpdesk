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
        $data = $request->validate([
            'nome' => 'required|string|max:50|unique:prioridades,nome',
            'nivel' => 'required|integer|min:1|max:10',
            'cor' => 'required|string|max:20',
        ]);

        Prioridade::create($data);

        return redirect()->route('prioridades.index')->with('sucesso', 'Prioridade criada!');
    }

    public function edit(Prioridade $prioridade)
    {
        return view('prioridades.edit', compact('prioridade'));
    }

    public function update(Request $request, Prioridade $prioridade)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:50|unique:prioridades,nome,'.$prioridade->id,
            'nivel' => 'required|integer|min:1|max:10',
            'cor' => 'required|string|max:20',
        ]);

        $prioridade->update($data);

        return redirect()->route('prioridades.index')->with('sucesso', 'Prioridade atualizada!');
    }

    public function destroy(Prioridade $prioridade)
    {
        $prioridade->delete();

        return redirect()->route('prioridades.index')->with('sucesso', 'Prioridade removida!');
    }
}
