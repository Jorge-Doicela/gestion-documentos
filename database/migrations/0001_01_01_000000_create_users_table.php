<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Crear tabla users sin clave foránea en tutor_id
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Solo columna tutor_id, nullable
            $table->unsignedBigInteger('tutor_id')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        // Agregar clave foránea auto-referencial en tutor_id
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('tutor_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });

        // Crear tabla password_reset_tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Crear tabla sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        // Eliminar clave foránea antes de borrar tabla users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tutor_id']);
        });

        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
