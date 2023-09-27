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
            $table->bigInteger('descricao');
            $table->bigInteger('pedidos_id');
            $table->foreign('pedidos_id')->references('id')->on('pedidos');
            $table->bigInteger('eventos_produtos_id');
            $table->foreign('eventos_produtos_id')->references('id')->on('eventos_produtos');
            $table->dateTime('data');
            $table->bigInteger('quantidade')->unique();
            $table->bigInteger('valor_unitario')->unique();
            $table->bigInteger('total')->unique();
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
