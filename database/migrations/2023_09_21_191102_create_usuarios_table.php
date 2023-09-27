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

        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->lineString('Nome');
            $table->integer('CPF/CNPJ')->unique();
            $table->lineString('CEP');
            $table->lineString('nº');
            $table->lineString('Telefone');
            $table->bigInteger('login')->unique();
            $table->bigInteger('senha');
            $table->lineString('interesses');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
