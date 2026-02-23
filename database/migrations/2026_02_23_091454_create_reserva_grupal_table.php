<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(){
        Schema::create('reserva_grupals', function (Blueprint $table) {
            // la clave primaria es clave ajena hacia reservas
            $table->foreignUuid('reserva_id')->primary()->constrained('reservas')->onDelete('cascade');
            
            // atributos
            $table->integer('aforo_max'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('reserva_grupals');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};