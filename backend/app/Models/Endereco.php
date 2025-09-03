<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'enderecos';

    protected $fillable = [
        'instituicao_id',
        'titulo',
        'cidade',
        'estado',
    ];

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class);
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