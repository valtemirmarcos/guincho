<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operador extends Model
{
    use HasFactory;

    // Se você deseja desabilitar timestamps
    // public $timestamps = false;

    // Se você deseja especificar o nome da tabela
    protected $table = 'operadores';

    // Se você deseja especificar a chave primária
    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'fone',
        'chave_maps',
        'endereco_base',
        'valor_km',
        'minimo_km',
        'minimo_valor',
        'slug'
    ];
    protected $casts = [
        'valor_km' => 'float',
        'minimo_km' => 'float',
        'minimo_valor' => 'float',
    ];
    public function taxa()
    {
        return $this->hasOne(Taxa::class, 'id');
    }
}
