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
        Schema::create('detalhe_pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->date('data');
            $table->integer('quantidade')->unique;
            $table->integer('valor_unitario')->unique;
            $table->double('total');
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->foreign('evento_id')->references('id')->on('eventos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalhe_pedidos');
    }
};
