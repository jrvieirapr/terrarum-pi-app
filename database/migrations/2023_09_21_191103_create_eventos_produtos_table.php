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

        Schema::create('eventos_produtos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('produtos_id');
            $table->foreign('produtos_id')->references('id')->on('produtos');
            $table->bigInteger('eventos_id');
            $table->foreign('eventos_id')->references('id')->on('eventos');
            $table->double('preco');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos_produtos');
    }
};
