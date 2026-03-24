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
        Schema::create('espacio_horario', function (Blueprint $table) {
            $table->foreignUuid('espacio_id')
                ->constrained('espacios')
                ->onDelete('cascade');
            $table->foreignUuid('horario_id')
                ->constrained('horarios')
                ->onDelete('restrict');
            $table->primary(['espacio_id', 'horario_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('espacio_horario');
    }
};
