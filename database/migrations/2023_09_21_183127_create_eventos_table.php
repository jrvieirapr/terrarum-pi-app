<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('Nome');
            $table->string('Tipo')->unique();
            $table->string('Descricao');
            $table->integer('Coordenadas')->unique();
            $table->double('valor')->unique();
            $table->string('Obs');
            $table->unsignedBigInteger('tipoproduto_id');;
            $table->foreign('tipoproduto_id')->references('id')->on('tipoprodutos');
            $table->unsignedBigInteger('destino_id');
            $table->foreign('destino_id')->references('id')->on('destinos');
            $table->timestamps();
        });
    }
    //$table->unsignedBigInteger('pedido_id');

      //      $table->foreign('pedido_id')->references('id')->on('pedidos');

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
