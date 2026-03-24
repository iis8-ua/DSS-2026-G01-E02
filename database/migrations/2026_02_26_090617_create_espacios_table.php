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
            $table->uuid('id')->primary();
            $table->string('nombre');
            $table->integer('aforo');
            $table->string('estado')->default('HABILITADO');
            $table->text('caracteristicas')->nullable();
            $table->string('imagen')->nullable();

            //Relacion con Localizacion
            $table->foreignUuid('localizacion_id')
                ->constrained('localizacions')
                ->onDelete('cascade');

            //Relacion con el tipo espacio
            $table->foreignUuid('tipo_espacio_id')->constrained('tipo_espacios');

            //Relacion con el horario
            $table->dateTime('horario_inicio');
            $table->dateTime('horario_fin');


            //con restrict impide borrar el horario si el espacio lo usa ya que la relacion representa eso
            $table->foreign(['horario_inicio', 'horario_fin'])
                ->references(['inicio', 'fin'])
                ->on('horarios')
                ->onDelete('restrict');

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
