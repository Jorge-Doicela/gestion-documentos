<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsActividadTable extends Migration
{
    public function up()
    {
        Schema::create('logs_actividad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('accion');
            $table->text('descripcion')->nullable();
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
            // No $table->timestamp('updated_at') ni $table->timestamps()
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs_actividad');
    }
}
