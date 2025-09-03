<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model
{
    use HasFactory;

    protected $table = 'instituicoes';

    protected $fillable = [
        'nome_curto',
        'nome_longo',
    ];

    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }

    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
}