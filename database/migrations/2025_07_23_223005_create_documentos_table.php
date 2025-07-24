<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tipo_documento_id')->constrained('tipos_documento')->cascadeOnDelete();
            $table->string('nombre_archivo');
            $table->text('ruta_archivo');
            $table->enum('estado', ['pendiente', 'no_aprobado', 'aprobado_tutor', 'aprobado_final'])->default('pendiente');
            $table->json('comentarios_json')->nullable();
            $table->timestamp('fecha_revision')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos');
    }
}
