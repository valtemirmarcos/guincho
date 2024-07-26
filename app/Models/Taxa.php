<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxa extends Model
{
    use HasFactory;

    // Se você deseja desabilitar timestamps
    // public $timestamps = false;

    // Se você deseja especificar o nome da tabela
    protected $table = 'taxas';

    // Se você deseja especificar a chave primária
    protected $primaryKey = 'id';

    protected $fillable = [
        'taxa_computacional_km',
    ];

    public function operador()
    {
        return $this->belongsTo(Operador::class, 'taxa_id');
    }
}
