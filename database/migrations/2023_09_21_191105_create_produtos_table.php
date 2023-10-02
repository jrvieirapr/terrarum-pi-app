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
        

        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao')->unique();
            $table->unsignedBigInteger('destino_id');
            $table->foreign('destino_id')->references('id')->on('destinos');
            $table->unsignedBigInteger('tipo_produto_id');
            $table->foreign('tipo_produto_id')->references('id')->on('tipo_produtos');
            $table->bigInteger('esta_ativo');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};