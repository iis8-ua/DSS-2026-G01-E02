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
        Schema::create('notificacions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('texto');
            $table->boolean('vista');

            $table->foreignUuid('incidencia_uuid')->constrained('incidencias')->cascadeOnDelete();
            //$table->foreignUuid('usuario_uuid')->constrained('usuarios')->noActionOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacions');
    }
};
