<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tecnico_zona', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tecnico_id')->constrained('tecnicos')->cascadeOnDelete();
            $table->foreignId('zona_id')->constrained('zonas')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['tecnico_id', 'zona_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tecnico_zona');
    }
};
