<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('versiones_documento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained()->onDelete('cascade');
            $table->integer('numero_version');
            $table->text('ruta_archivo');
            $table->unsignedBigInteger('creado_por');
            $table->text('motivo_cambio')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->foreign('creado_por')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('versiones_documento');
    }
};
