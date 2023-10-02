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

        Schema::create('detalhes_pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->unsignedBigInteger('pedido_id');
            $table->foreign('pedido_id')->references('id')->on('pedidos');
            $table->unsignedBigInteger('evento_id');
            $table->foreign('evento_id')->references('id')->on('eventos');
            $table->unsignedBigInteger('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->bigInteger('quantidade');
            $table->double('valor_unitario');
            $table->double('valor_total');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalhes_pedidos');
    }
};
