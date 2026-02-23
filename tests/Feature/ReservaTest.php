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

class ReservaTest extends TestCase
{
    // para limpiar la base de datos tras cada test
    use RefreshDatabase; 

    // Función auxiliar para crear un espacio válido
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

    // test para comprobar que una reserva pertenece a un usuario
    public function test_reserva_pertenece_a_un_usuario(){
        // Arrange
        // creamos un usuario y un espacio para la reserva
        $user = User::factory()->create(); 
        $espacio = $this->crearEspacioValido();
        
        // Act
        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'user_id' => $user->id,
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addHours(1),
            'estado' => 'pendiente'
        ]);

        // assert
        $this->assertInstanceOf(User::class, $reserva->user);
        $this->assertEquals($user->id, $reserva->user->id);
    }

    // test para comrpobar que una reserva está asociada a un espacio
    public function test_reserva_pertenece_a_un_espacio(){
        // arrange: usuario y espacio
        $user = User::factory()->create();
        $espacio = $this->crearEspacioValido();
        
        // act
        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'user_id' => $user->id,
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addHours(1),
            'estado' => 'pendiente'
        ]);

        // assert
        $this->assertInstanceOf(Espacio::class, $reserva->espacio);
        $this->assertEquals($espacio->id, $reserva->espacio->id);
    }

    // test para comprobar que una reserva es una reserva grupal
    public function test_reserva_tiene_una_reserva_grupal(){
        // arrange: usuario y espacio
        $user = User::factory()->create();
        $espacio = $this->crearEspacioValido();
        
        // ACT: crear la reserva y su reserva grupal
        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'user_id' => $user->id,
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addHours(1),
            'estado' => 'pendiente'
        ]);

        $grupal = ReservaGrupal::create([
            'reserva_id' => $reserva->id,
            'aforo_max' => 20
        ]);

        $reserva->refresh();

        // assert
        $this->assertInstanceOf(ReservaGrupal::class, $reserva->reservaGrupal);
        $this->assertEquals(20, $reserva->reservaGrupal->aforo_max);
    }
}