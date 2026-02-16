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
            $table->uuid();
            $table->timestamps();
            $table->string('texto');
            $table->boolean('vista');
            $table->uuid('incidencia_uuid');
            $table->uuid('usuario_uuid');

            $table->foreignUuid('incidencia_uuid')->constrained('')->cascadeOnDelete();
            $table->foreignUuid('usuario_uuid')->constrained('')->noActionOnDelete();

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
