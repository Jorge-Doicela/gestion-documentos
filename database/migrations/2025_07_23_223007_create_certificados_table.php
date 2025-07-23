<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->uuid('uuid')->unique();
            $table->text('ruta_pdf');
            $table->string('hash_verificacion');
            $table->unsignedBigInteger('firmado_por');
            $table->timestamp('fecha_emision')->useCurrent();
            $table->timestamps();

            $table->foreign('firmado_por')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
