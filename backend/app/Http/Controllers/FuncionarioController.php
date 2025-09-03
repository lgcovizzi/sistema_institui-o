<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index()
    {
        return response()->json(Funcionario::with(['instituicao', 'endereco', 'departamento'])->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'instituicao_id' => 'required|exists:instituicoes,id',
            'endereco_id' => 'required|exists:enderecos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'nome' => 'required|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'horario_trabalho' => 'nullable|string|max:255',
        ]);

        $funcionario = Funcionario::create($request->all());

        return response()->json($funcionario->load(['instituicao', 'endereco', 'departamento']), 201);
    }

    public function show(Funcionario $funcionario)
    {
        return response()->json($funcionario->load(['instituicao', 'endereco', 'departamento']));
    }

    public function update(Request $request, Funcionario $funcionario)
    {
        $request->validate([
            'instituicao_id' => 'sometimes|exists:instituicoes,id',
            'endereco_id' => 'sometimes|exists:enderecos,id',
            'departamento_id' => 'sometimes|exists:departamentos,id',
            'nome' => 'sometimes|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'horario_trabalho' => 'nullable|string|max:255',
        ]);

        $funcionario->update($request->all());

        return response()->json($funcionario->load(['instituicao', 'endereco', 'departamento']));
    }

    public function destroy(Funcionario $funcionario)
    {
        $funcionario->delete();
        return response()->json(null, 204);
    }
}