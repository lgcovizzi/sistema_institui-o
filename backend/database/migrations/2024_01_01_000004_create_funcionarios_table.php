<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instituicao_id')->constrained('instituicoes')->onDelete('cascade');
            $table->foreignId('endereco_id')->constrained('enderecos')->onDelete('cascade');
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('cascade');
            $table->string('nome');
            $table->string('cargo')->nullable();
            $table->string('horario_trabalho')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};