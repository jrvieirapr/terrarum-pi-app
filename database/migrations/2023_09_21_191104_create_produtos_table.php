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
            $table->lineString('descricao')->unique();
            $table->unsignedBigInteger('destino_id');
            $table->foreign('destino_id')->references('id')->on('destinos');
            $table->unsignedBigInteger('tipos_de_produtos_id');
            $table->foreign('tipos_de_produtos_id')->references('id')->on('tipos_de_produtos');
            $table->bigInteger('esta_ativo');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
