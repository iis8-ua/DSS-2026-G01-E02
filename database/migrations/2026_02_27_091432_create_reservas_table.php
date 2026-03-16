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

            // Relacion con el alumno y el espacio
            $table->foreignUuid('alumno_id')->constrained('usuarios')->onDelete('restrict');
            $table->foreignUuid('espacio_id')->constrained('espacios')->onDelete('cascade');

            $table->dateTime('hora_inicio');
            $table->dateTime('hora_fin');


            // EstadoReserva
            $table->string('estado')->default(\App\Enums\EstadoReserva::PENDIENTE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('reservas');
    }
};
