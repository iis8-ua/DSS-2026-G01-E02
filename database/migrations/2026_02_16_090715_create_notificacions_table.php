<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('titulo');
            $table->text('texto');
            $table->boolean('vista')->default(false);
            $table->string('imagen')->nullable();

            $table->foreignUuid('user_id')
                ->constrained('usuarios')
                ->onDelete("cascade");

            $table->foreignUuid('incidencia_id')
                ->nullable()
                ->constrained('incidencias')
                ->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
