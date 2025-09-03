<?php

namespace App\Http\Controllers;

use App\Models\Instituicao;
use Illuminate\Http\Request;

class InstituicaoController extends Controller
{
    public function index()
    {
        return response()->json(Instituicao::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome_curto' => 'required|string|max:50|unique:instituicoes,nome_curto',
            'nome_longo' => 'required|string|max:255|unique:instituicoes,nome_longo',
        ]);

        $instituicao = Instituicao::create($request->all());

        return response()->json($instituicao, 201);
    }

    public function show(Instituicao $instituicao)
    {
        return response()->json($instituicao->load(['enderecos.departamentos']));
    }

    public function update(Request $request, Instituicao $instituicao)
    {
        $request->validate([
            'nome_curto' => 'sometimes|string|max:50|unique:instituicoes,nome_curto,'.$instituicao->id,
            'nome_longo' => 'sometimes|string|max:255|unique:instituicoes,nome_longo,'.$instituicao->id,
        ]);

        $instituicao->update($request->all());

        return response()->json($instituicao);
    }

    public function destroy(Instituicao $instituicao)
    {
        $instituicao->delete();
        return response()->json(null, 204);
    }
}