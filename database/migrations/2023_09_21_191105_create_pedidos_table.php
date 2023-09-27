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

        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('Tipo');
            $table->dateTime('Data');
            $table->bigInteger('Produto')->unique();
            $table->bigInteger('Quantidade')->unique()->nullable();
            $table->bigInteger('preco')->unique();
            $table->bigInteger('Total');
            $table->bigInteger('OBS');
            $table->bigInteger('Usuarios_id');
            $table->foreign('Usuarios_id')->references('id')->on('usuarios');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
