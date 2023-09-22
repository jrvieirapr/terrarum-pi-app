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
            $table->bigInteger('tipoprodutos_id');
            $table->foreign('tipoprodutos_id')->references('id')->on('tipoprodutos');
            $table->bigInteger('destinos_id');
            $table->foreign('destinos_id')->references('id')->on('destinos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
