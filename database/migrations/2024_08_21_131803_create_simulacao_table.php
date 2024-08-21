<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimulacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulacao', function (Blueprint $table) {
            $table->id();
            $table->string('origem', 1000);
            $table->string('destino', 1000);
            $table->string('txt_km', 50);
            $table->decimal('kms', 10,5);
            $table->decimal('kms_ida_volta', 10,5);
            $table->decimal('taxa_computacional_km', 10,2);
            $table->decimal('taxa_guicho_km', 10,2);
            $table->decimal('minimo_km', 10,2);
            $table->decimal('minimo_valor', 10,2);
            $table->decimal('valorTaxaComputacional', 10,2);
            $table->decimal('valorGuincho', 10,2);
            $table->string('cpf', 50);
            $table->string('fone', 50);
            $table->integer('id_operador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simulacao');
    }
}
