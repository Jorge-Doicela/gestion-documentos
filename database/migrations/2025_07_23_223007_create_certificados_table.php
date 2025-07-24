<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificadosTable extends Migration
{
    public function up()
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->uuid('uuid')->unique();
            $table->text('ruta_pdf');
            $table->string('hash_verificacion');
            $table->foreignId('firmado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('fecha_emision')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificados');
    }
}
