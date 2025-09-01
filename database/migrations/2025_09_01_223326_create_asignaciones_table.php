<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plaza_id')->constrained('plazas')->onDelete('cascade');
            $table->foreignId('estudiante_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->onDelete('set null'); // tutor de la empresa o docente
            $table->enum('estado', ['asignado', 'cancelado', 'finalizado'])->default('asignado');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaciones');
    }
};
