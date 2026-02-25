<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Reserva;
use App\Models\ReservaGrupal;
use App\Models\User;
use App\Models\Espacio;
use App\Models\TipoEspacio;
use App\Models\Localizacion;
use App\Enums\EstadoReserva;

class ReservaGrupalTest extends TestCase
{
    // para limpiar la base de datos tras cada test
    use RefreshDatabase;

    // misma función que en la Reserva para crear un espacio válido
    private function crearEspacioValido(){
        $tipo = TipoEspacio::create(['nombre' => 'Aula']);
        $loc = Localizacion::create(['latitud' => 1.0, 'longitud' => 1.0, 'piso' => 1]);
        
        return Espacio::create([
            'nombre' => 'Aula Magna',
            'aforo' => 50,
            'tipo_espacio_id' => $tipo->id,
            'loc_latitud' => $loc->latitud,
            'loc_longitud' => $loc->longitud,
            'loc_piso' => $loc->piso,
            'horario_inicio' => '2026-01-01 08:00:00',
            'horario_fin' => '2026-01-01 10:00:00',
        ]);
    }

    // test para comprobar que una resrva grupal pertenece a una reserva base
    public function test_reserva_grupal_pertenece_a_una_reserva_base(){
        // arrange: creamos usuario y espacio
        $user = User::factory()->create();
        $espacio = $this->crearEspacioValido();
        
        // act: creamos la reserva y su reserva grupal asociada
        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'user_id' => $user->id,
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addHours(1),
            'estado' => EstadoReserva::PENDIENTE
        ]);

        $grupal = ReservaGrupal::create([
            'reserva_id' => $reserva->id,
            'aforo_max' => 10
        ]);

        // arrange
        $this->assertInstanceOf(Reserva::class, $grupal->reserva);
        $this->assertEquals($reserva->id, $grupal->reserva->id);
    }

    public function test_reserva_grupal_tiene_multiples_miembros(){
        // arrange: creamos usuaro y espacio
        $creador = User::factory()->create();
        $espacio = $this->crearEspacioValido();
        
        // act: creamos reserva y reserva grupal
        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'user_id' => $creador->id,
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addHours(1),
            'estado' => EstadoReserva::PENDIENTE
        ]);

        $grupal = ReservaGrupal::create([
            'reserva_id' => $reserva->id,
            'aforo_max' => 10
        ]);

        // añadimos miembros a la reserva grupal
        $alumno1 = User::factory()->create();
        $alumno2 = User::factory()->create();

        $grupal->miembros()->attach([$alumno1->id, $alumno2->id]);

        // assert
        $this->assertCount(2, $grupal->miembros);
        $this->assertTrue($grupal->miembros->contains($alumno1));
        $this->assertTrue($grupal->miembros->contains($alumno2));
    }
}