<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_trabajo_id')->constrained('ordenes_trabajo')->cascadeOnDelete();
            $table->decimal('monto', 12, 2);
            $table->enum('metodo', ['efectivo', 'transferencia', 'tarjeta', 'otro'])->default('efectivo');
            $table->enum('estado', ['pendiente', 'completado', 'fallido', 'reembolsado'])->default('pendiente');
            $table->string('referencia')->nullable();
            $table->timestamp('fecha_pago')->nullable();
            $table->timestamps();

            $table->index('orden_trabajo_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
