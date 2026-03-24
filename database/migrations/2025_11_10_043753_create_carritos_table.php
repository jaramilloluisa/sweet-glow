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
        Schema::create('carritos', function (Blueprint $table) {
            $table->id('id_carrito');
            $table->unsignedBigInteger('id_usuario')->nullable(false);
            $table->enum('status', ['active', 'checked_out'])->default('active');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            $table->timestamps();
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carritos');
    }
};
