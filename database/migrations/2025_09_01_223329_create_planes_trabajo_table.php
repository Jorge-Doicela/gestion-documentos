<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('planes_trabajo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asignacion_id')->constrained('asignaciones')->onDelete('cascade');
            $table->text('objetivos')->nullable();
            $table->text('actividades')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planes_trabajo');
    }
};
