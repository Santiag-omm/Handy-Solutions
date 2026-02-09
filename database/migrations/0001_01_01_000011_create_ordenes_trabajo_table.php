<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_trabajo', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->foreignId('solicitud_id')->constrained('solicitudes')->cascadeOnDelete();
            $table->foreignId('tecnico_id')->constrained('tecnicos')->cascadeOnDelete();
            $table->foreignId('cotizacion_id')->nullable()->constrained('cotizaciones')->nullOnDelete();
            $table->foreignId('asignado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('fecha_asignada')->nullable();
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();
            $table->enum('estado', [
                'asignada',
                'en_camino',
                'en_proceso',
                'completada',
                'cancelada'
            ])->default('asignada');
            $table->text('notas_tecnico')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['estado', 'fecha_asignada']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_trabajo');
    }
};
