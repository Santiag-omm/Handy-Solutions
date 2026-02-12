<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tecnico_id')->constrained('tecnicos')->cascadeOnDelete();
            $table->unsignedTinyInteger('dia_semana'); // 0=domingo, 1=lunes, ..., 6=sábado
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->index(['tecnico_id', 'dia_semana']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
