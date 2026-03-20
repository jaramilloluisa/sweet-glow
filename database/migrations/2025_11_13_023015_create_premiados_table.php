<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('premiados', function (Blueprint $table) {
            $table->id('id_premiado');
            $table->unsignedBigInteger('id_premio')->nullable(false);
            $table->unsignedBigInteger('id_usuario')->nullable(false);
            $table->unsignedBigInteger('id_inscripcion')->nullable(false);
            $table->foreign('id_premio')->references('id_premio')->on('premios')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_inscripcion')->references('id_inscripcion')->on('inscripciones_regalo')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('premiados');
    }
};