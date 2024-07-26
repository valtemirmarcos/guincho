<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operadores', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 200); 
            $table->string('email', 200);
            $table->string('cpf', 20);
            $table->string('fone', 20);
            $table->string('chave_maps', 50);
            $table->string('endereco_base', 100);
            $table->float('valor_km', 10,2);
            $table->float('minimo_km', 10,2);
            $table->float('minimo_valor', 10,2);
            $table->integer('taxa_id');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operadores');
    }
}
