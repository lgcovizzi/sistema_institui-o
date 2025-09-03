<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function index()
    {
        return response()->json(Endereco::with('instituicao')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'instituicao_id' => 'required|exists:instituicoes,id',
            'titulo' => 'required|string|max:255|unique:enderecos,titulo,NULL,id,instituicao_id,'.$request->instituicao_id,
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
        ]);

        $endereco = Endereco::create($request->all());

        return response()->json($endereco->load('instituicao'), 201);
    }

    public function show(Endereco $endereco)
    {
        return response()->json($endereco->load('instituicao'));
    }

    public function byInstituicao($instituicao_id)
    {
        $enderecos = Endereco::where('instituicao_id', $instituicao_id)->get();
        return response()->json($enderecos);
    }

    public function update(Request $request, Endereco $endereco)
    {
        $request->validate([
            'instituicao_id' => 'sometimes|exists:instituicoes,id',
            'titulo' => 'sometimes|string|max:255|unique:enderecos,titulo,'.$endereco->id.',id,instituicao_id,'.$request->instituicao_id,
            'cidade' => 'sometimes|string|max:255',
            'estado' => 'sometimes|string|max:2',
        ]);

        $endereco->update($request->all());

        return response()->json($endereco->load('instituicao'));
    }

    public function destroy(Endereco $endereco)
    {
        $endereco->delete();
        return response()->json(null, 204);
    }
}