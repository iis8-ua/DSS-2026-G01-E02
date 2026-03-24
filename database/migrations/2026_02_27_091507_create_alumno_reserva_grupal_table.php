<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(){
        Schema::create('alumno_reserva_grupal', function (Blueprint $table) {
            $table->id();

            // vinculamos una reserva grupal con un usuario
            // atributo de la lista de miembros
            $table->foreignUuid('reserva_grupal_id')->constrained('reserva_grupals', 'reserva_id')->onDelete('cascade');
            $table->foreignUuid('alumno_id')->constrained('usuarios')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('alumno_reserva_grupal');
    }
};
