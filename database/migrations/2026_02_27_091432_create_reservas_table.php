<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(){
        Schema::create('reservas', function (Blueprint $table) {
            // el id es la clave primaria
            $table->uuid('id')->primary();

            // Relaciones con usuario y el espacio
            $table->foreignUuid('user_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignUuid('espacio_id')->constrained('espacios')->onDelete('cascade');

            // relacion con horario
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');

            $table->foreign(['fecha_inicio', 'fecha_fin'])
                ->references(['inicio', 'fin'])
                ->on('horarios')
                ->onDelete('restrict');

            // EstadoReserva
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('reservas');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
