<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulacao extends Model
{
    use HasFactory;

    // Se você deseja desabilitar timestamps
    // public $timestamps = false;

    // Se você deseja especificar o nome da tabela
    protected $table = 'simulacao';

    // Se você deseja especificar a chave primária
    protected $primaryKey = 'id';

    protected $fillable = [
        'origem',
        'destino',
        'txt_km',
        'kms',
        'kms_ida_volta',
        'taxa_computacional_km',
        'taxa_guicho_km',
        'minimo_km',
        'minimo_valor',
        'valorTaxaComputacional',
        'valorGuincho',
        'cpf',
        'fone',
        'id_operador'
    ];
    protected $casts = [
        'kms' => 'float',
        'kms_ida_volta' => 'float',
        'minimo_km' => 'float',
        'taxa_computacional_km' => 'float',
        'taxa_guicho_km' => 'float',
        'minimo_valor' => 'float',
        'valorTaxaComputacional' => 'float',
        'valorGuincho' => 'float',
    ];

}
