<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposDocumentoTable extends Migration
{
    public function up()
    {
        Schema::create('tipos_documento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->boolean('obligatorio')->default(false);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos_documento');
    }
}
