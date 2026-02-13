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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('email', 255);
            $table->string('telefono', 50)->nullable();
            $table->string('asunto', 50);
            $table->text('mensaje');
            $table->string('estado', 20)->default('pendiente'); // pendiente, leído, respondido, cerrado
            $table->text('notas_admin')->nullable();
            $table->timestamp('fecha_envio');
            $table->timestamp('fecha_respuesta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
