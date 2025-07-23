<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('normativas_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_documento_id')->constrained()->onDelete('cascade');
            $table->longText('contenido');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('normativas_documentos');
    }
};
