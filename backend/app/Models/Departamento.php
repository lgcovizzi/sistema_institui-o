<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos';

    protected $fillable = [
        'instituicao_id',
        'endereco_id',
        'nome',
    ];

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class);
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
}