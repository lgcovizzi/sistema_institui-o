<?php

namespace App\Http\Controllers;

use App\Models\Instituicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstituicaoController extends Controller
{
    public function index()
    {
        $instituicoes = Instituicao::with(['enderecos.departamentos'])
            ->withCount('registros')
            ->get();
        
        return response()->json($instituicoes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome_longo' => 'required|string|max:255|unique:instituicaos',
            'nome_curto' => 'required|string|max:255|unique:instituicaos',
        ]);

        $instituicao = Instituicao::create($request->all());
        
        return response()->json($instituicao, 201);
    }

    public function show(Instituicao $instituicao)
    {
        $instituicao->load(['enderecos.departamentos'])
            ->loadCount('registros');
        
        return response()->json($instituicao);
    }

    public function update(Request $request, Instituicao $instituicao)
    {
        $request->validate([
            'nome_longo' => 'required|string|max:255|unique:instituicaos,nome_longo,' . $instituicao->id,
            'nome_curto' => 'required|string|max:255|unique:instituicaos,nome_curto,' . $instituicao->id,
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