<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plazas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->string('area_practica');
            $table->string('periodo_academico');
            $table->string('carrera');
            $table->text('habilidades_requeridas')->nullable();
            $table->json('documentos_previos')->nullable();
            $table->integer('vacantes')->default(1);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plazas');
    }
};
