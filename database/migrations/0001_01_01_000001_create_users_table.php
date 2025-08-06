<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Crear tabla users con todos los campos y claves foráneas
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Nuevos campos
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('identificacion')->unique()->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro'])->nullable();

            // Foreign keys
            $table->unsignedBigInteger('tutor_id')->nullable();
            $table->foreignId('carrera_id')->nullable()->constrained('carreras')->nullOnDelete();

            $table->rememberToken();
            $table->timestamps();

            // Definir la FK auto-referencial tutor_id
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
        // Para eliminar la tabla users debemos primero eliminar las FK
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tutor_id']);
            $table->dropForeign(['carrera_id']);
        });

        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
