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

            // Relación con el usuario (estudiante)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Relación con el tipo de documento
            $table->foreignId('tipo_documento_id')->constrained('tipos_documento')->onDelete('cascade');

            // Datos del archivo
            $table->string('nombre_archivo');
            $table->string('ruta_archivo');

            // Diferencia quién subió el documento
            $table->enum('subido_por', ['estudiante', 'tutor'])->default('estudiante');

            // Estados del documento
            $table->enum('estado', [
                'pendiente_tutor',         // Subido, esperando revisión del tutor
                'rechazado_tutor',         // Tutor lo rechazó
                'aprobado_tutor',          // Tutor aprobó, pasa al coordinador
                'rechazado_coordinador',   // Coordinador lo rechazó
                'aprobado_final'           // Aprobado por coordinador, certificado generado
            ])->default('pendiente_tutor');

            // Comentarios en formato JSON opcional
            $table->json('comentarios_json')->nullable();

            // Fecha de última revisión (puede ser null si nunca fue revisado aún)
            $table->timestamp('fecha_revision')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos');
    }
}
