<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNormativasDocumentosTable extends Migration
{
    public function up()
    {
        Schema::create('normativas_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_documento_id')->constrained('tipos_documento')->cascadeOnDelete();
            $table->longText('contenido');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('normativas_documentos');
    }
}
