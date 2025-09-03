<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = 'funcionarios';

    protected $fillable = [
        'instituicao_id',
        'endereco_id',
        'departamento_id',
        'nome',
        'cargo',
        'horario_trabalho',
    ];

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class);
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}