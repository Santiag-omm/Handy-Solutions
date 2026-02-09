<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 20)->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('servicio_id')->constrained('servicios')->cascadeOnDelete();
            $table->foreignId('zona_id')->nullable()->constrained('zonas')->nullOnDelete();
            $table->text('direccion');
            $table->text('descripcion_problema')->nullable();
            $table->date('fecha_deseada')->nullable();
            $table->enum('urgencia', ['baja', 'media', 'alta'])->default('media');
            $table->enum('estado', [
                'pendiente',
                'validada',
                'rechazada',
                'cotizada',
                'asignada',
                'en_proceso',
                'completada',
                'cancelada'
            ])->default('pendiente');
            $table->json('fotos')->nullable(); // rutas de imágenes
            $table->text('observaciones_admin')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['estado', 'created_at']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
