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
        Schema::create('localizacions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);
            $table->integer('piso');

            $table->unique(['latitud', 'longitud', 'piso']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //se pone ya que sino da error por las relaciones
        Schema::dropIfExists('espacios');
        Schema::dropIfExists('localizacions');
    }
};
