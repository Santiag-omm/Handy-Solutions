<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->constrained('solicitudes')->cascadeOnDelete();
            $table->decimal('monto', 12, 2);
            $table->enum('tipo', ['automatica', 'manual'])->default('automatica');
            $table->text('observaciones')->nullable();
            $table->foreignId('ajustado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('solicitud_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
