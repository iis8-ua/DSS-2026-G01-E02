<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(){
        Schema::create('reserva_grupal_user', function (Blueprint $table) {
            $table->id();
            
            // vinculamos una reserva grupal con un usuario
            // atributo de la lista de miembros
            $table->foreignUuid('reserva_grupal_id')->constrained('reserva_grupals', 'reserva_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};