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
            $table->date('Data');
            $table->string('Produto');
            $table->bigInteger('Quantidade');
            $table->bigInteger('preco');
            $table->bigInteger('Total');
            $table->string('OBS');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->unsignedBigInteger('detalhes_pedido_id');
            $table->foreign('detalhes_pedido_id')->references('id')->on('detalhes_pedidos');
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
