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
        Schema::disableForeignKeyConstraints();

        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('Nome');
            $table->string('Descricao');
            $table->string('Coordenadas')->unique();
            $table->double('valor')->unique();
            $table->string('Obs');
            $table->unsignedBigInteger('tipos_de_produto_id');
            $table->foreign('tipos_de_produto_id')->references('id')->on('tipos_de_produtos');
            $table->unsignedBigInteger('destino_id');
            $table->foreign('destino_id')->references('id')->on('destinos');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
