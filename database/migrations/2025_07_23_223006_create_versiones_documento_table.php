<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionesDocumentoTable extends Migration
{
    public function up()
    {
        Schema::create('versiones_documento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained('documentos')->cascadeOnDelete();
            $table->integer('numero_version');
            $table->text('ruta_archivo');
            $table->foreignId('creado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->text('motivo_cambio')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('versiones_documento');
    }
}
