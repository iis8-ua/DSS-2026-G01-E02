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
            $table->float('latitud');
            $table->float('longitud');
            $table->integer('piso');
            $table->timestamps();

            $table->primary(['latitud', 'longitud', 'piso']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localizacions');
    }
};
