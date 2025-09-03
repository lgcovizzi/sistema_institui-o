<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        return response()->json(Departamento::with(['instituicao', 'endereco'])->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'instituicao_id' => 'required|exists:instituicoes,id',
            'endereco_id' => 'required|exists:enderecos,id',
            'nome' => 'required|string|max:255|unique:departamentos,nome,NULL,id,endereco_id,'.$request->endereco_id,
        ]);

        $departamento = Departamento::create($request->all());

        return response()->json($departamento->load(['instituicao', 'endereco']), 201);
    }

    public function show(Departamento $departamento)
    {
        return response()->json($departamento->load(['instituicao', 'endereco']));
    }

    public function byInstituicao($instituicao_id)
    {
        $departamentos = Departamento::where('instituicao_id', $instituicao_id)
            ->with(['instituicao', 'endereco'])
            ->get();
        return response()->json($departamentos);
    }

    public function update(Request $request, Departamento $departamento)
    {
        $request->validate([
            'instituicao_id' => 'sometimes|exists:instituicoes,id',
            'endereco_id' => 'sometimes|exists:enderecos,id',
            'nome' => 'sometimes|string|max:255|unique:departamentos,nome,'.$departamento->id.',id,endereco_id,'.$request->endereco_id,
        ]);

        $departamento->update($request->all());

        return response()->json($departamento->load(['instituicao', 'endereco']));
    }

    public function destroy(Departamento $departamento)
    {
        $departamento->delete();
        return response()->json(null, 204);
    }
}