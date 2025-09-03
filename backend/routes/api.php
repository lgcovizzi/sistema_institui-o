<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\FuncionarioController;

Route::middleware('api')->group(function () {
    // Rotas para Instituições
    Route::get('/instituicoes', [InstituicaoController::class, 'index']);
    Route::post('/instituicoes', [InstituicaoController::class, 'store']);
    Route::get('/instituicoes/{instituicao}', [InstituicaoController::class, 'show']);
    Route::put('/instituicoes/{instituicao}', [InstituicaoController::class, 'update']);
    Route::delete('/instituicoes/{instituicao}', [InstituicaoController::class, 'destroy']);

    // Rotas para Endereços
    Route::get('/enderecos', [EnderecoController::class, 'index']);
    Route::post('/enderecos', [EnderecoController::class, 'store']);
    Route::get('/enderecos/{endereco}', [EnderecoController::class, 'show']);
    Route::put('/enderecos/{endereco}', [EnderecoController::class, 'update']);
    Route::delete('/enderecos/{endereco}', [EnderecoController::class, 'destroy']);
    Route::get('/instituicoes/{instituicao_id}/enderecos', [EnderecoController::class, 'byInstituicao']);

    // Rotas para Departamentos
    Route::get('/departamentos', [DepartamentoController::class, 'index']);
    Route::post('/departamentos', [DepartamentoController::class, 'store']);
    Route::get('/departamentos/{departamento}', [DepartamentoController::class, 'show']);
    Route::put('/departamentos/{departamento}', [DepartamentoController::class, 'update']);
    Route::delete('/departamentos/{departamento}', [DepartamentoController::class, 'destroy']);
    Route::get('/instituicoes/{instituicao_id}/departamentos', [DepartamentoController::class, 'byInstituicao']);

    // Rotas para Funcionários
    Route::get('/funcionarios', [FuncionarioController::class, 'index']);
    Route::post('/funcionarios', [FuncionarioController::class, 'store']);
    Route::get('/funcionarios/{funcionario}', [FuncionarioController::class, 'show']);
    Route::put('/funcionarios/{funcionario}', [FuncionarioController::class, 'update']);
    Route::delete('/funcionarios/{funcionario}', [FuncionarioController::class, 'destroy']);
});