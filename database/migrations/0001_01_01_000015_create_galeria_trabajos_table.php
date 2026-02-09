<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeria_trabajos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_trabajo_id')->nullable()->constrained('ordenes_trabajo')->nullOnDelete();
            $table->string('imagen');
            $table->string('titulo')->nullable();
            $table->text('descripcion')->nullable();
            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->nullOnDelete();
            $table->integer('orden')->default(0);
            $table->boolean('destacado')->default(false);
            $table->boolean('visible')->default(true);
            $table->timestamps();

            $table->index('visible');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeria_trabajos');
    }
};
