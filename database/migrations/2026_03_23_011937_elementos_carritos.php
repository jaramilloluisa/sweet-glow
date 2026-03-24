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
        Schema::create('elementos_carritos', function (Blueprint $table) {
            $table->id('id_elemento_carrito');
            $table->unsignedBigInteger('id_producto')->nullable(false);
            $table->unsignedBigInteger('id_carrito')->nullable(false);
            $table->integer('cantidad')->nullable(false);
            $table->decimal('price', 10, 2)->nullable(false);
            $table->foreign('id_producto')->references('id_producto')->on('productos');
            $table->foreign('id_carrito')->references('id_carrito')->on('carritos');
            $table->timestamps();
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementos_carritos');
    }
};
