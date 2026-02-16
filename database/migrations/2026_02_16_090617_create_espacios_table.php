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
        Schema::create('espacios', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('nombre');
            $table->integer('aforo');
            $table->string('estado')->default('HABILITADO');
            $table->text('caracteristicas')->nullable();
            $table->timestamps();

            //Para la relacion de la localizacion, ya que la clave primaria alli esta compuesta por estas tres
            $table->float('loc_latitud');
            $table->float('loc_longitud');
            $table->integer('loc_piso');

            $table->foreign(['loc_latitud', 'loc_longitud', 'loc_piso'])
                ->references(['latitud', 'longitud', 'piso'])
                ->on('localizacions')
                ->onDelete('cascade');

            //Relacion con el tipo espacio
            $table->foreignUuid('tipo_espacio_id')->constrained('tipo_espacios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('espacios');
    }
};
