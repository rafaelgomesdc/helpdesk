<?php

// =============================================================================
//  NÍVEIS DE PRIORIDADE DOS CHAMADOS
//  Responsável: Dupla 4 — Gabriel e Murilo
//  Módulo: Categorias, Prioridades, Dashboard e Base
// =============================================================================

namespace App\Http\Controllers;

use App\Models\Prioridade;
use Illuminate\Http\Request;

class PrioridadeController extends Controller
{
    // -------------------------------------------------------------------------
    // Lista todas as prioridades ordenadas pelo nível de urgência (descendente)
    // -------------------------------------------------------------------------
    public function index()
    {
        $prioridades = Prioridade::orderByDesc('nivel')->get();

        return view('prioridades.index', compact('prioridades'));
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de criação de nova prioridade
    // -------------------------------------------------------------------------
    public function create()
    {
        return view('prioridades.create');
    }

    // -------------------------------------------------------------------------
    // Persiste a nova prioridade no banco de dados
    // -------------------------------------------------------------------------
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'  => ['required', 'string', 'max:50', 'unique:prioridades,nome'],
            'nivel' => ['required', 'integer', 'min:1', 'max:10'],
            'cor'   => ['nullable', 'string', 'max:20'],
        ]);

        Prioridade::create($dados);

        return redirect()->route('prioridades.index')
            ->with('sucesso', 'Prioridade cadastrada com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de edição de uma prioridade
    // -------------------------------------------------------------------------
    public function edit(Prioridade $prioridade)
    {
        return view('prioridades.edit', compact('prioridade'));
    }

    // -------------------------------------------------------------------------
    // Atualiza os dados da prioridade
    // -------------------------------------------------------------------------
    public function update(Request $request, Prioridade $prioridade)
    {
        $dados = $request->validate([
            'nome'  => ['required', 'string', 'max:50', 'unique:prioridades,nome,'.$prioridade->id],
            'nivel' => ['required', 'integer', 'min:1', 'max:10'],
            'cor'   => ['nullable', 'string', 'max:20'],
        ]);

        $prioridade->update($dados);

        return redirect()->route('prioridades.index')
            ->with('sucesso', 'Prioridade atualizada com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Remove a prioridade permanentemente
    // -------------------------------------------------------------------------
    public function destroy(Prioridade $prioridade)
    {
        $prioridade->delete();

        return redirect()->route('prioridades.index')
            ->with('sucesso', 'Prioridade removida com sucesso!');
    }
}
