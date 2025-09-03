<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instituicao_id')->constrained('instituicoes')->onDelete('cascade');
            $table->string('titulo')->unique();
            $table->string('cidade');
            $table->string('estado', 2);
            $table->timestamps();
            
            $table->unique(['titulo', 'instituicao_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};