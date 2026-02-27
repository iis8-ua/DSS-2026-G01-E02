<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Reserva;
use App\Models\ReservaGrupal;
use App\Models\Usuario;
use App\Models\Espacio;
use App\Models\TipoEspacio;
use App\Models\Localizacion;
use App\Enums\EstadoReserva;
use App\Models\Horario;

class ReservaGrupalTest extends TestCase
{
    // para limpiar la base de datos tras cada test
    use RefreshDatabase;

    private $horaInicio = '08:00:00';
    private $horaFin = '10:00:00';

    // misma función que en la Reserva para crear un espacio válido
    private function crearEspacioValido(){
        $tipo = TipoEspacio::create(['nombre' => 'Aula']);
        $loc = Localizacion::create(['latitud' => 1.0, 'longitud' => 1.0, 'piso' => 1]);
        $hor=Horario::create([
            'inicio' => $this->horaInicio,
            'fin' => $this->horaFin
        ]);

        return Espacio::create([
            'nombre' => 'Aula Magna',
            'aforo' => 50,
            'tipo_espacio_id' => $tipo->id,
            'loc_latitud' => $loc->latitud,
            'loc_longitud' => $loc->longitud,
            'loc_piso' => $loc->piso,
            'horario_inicio' => $hor->inicio,
            'horario_fin' => $hor->fin,
        ]);
    }

    // test para comprobar que una resrva grupal pertenece a una reserva base
    public function test_reserva_grupal_pertenece_a_una_reserva_base(){
        // arrange: creamos usuario y espacio
        $user = Usuario::create([
            'name' => 'Juan',
            'apellidos' => 'Pruebas',
            'email' => 'juan@test.com',
            'password' => bcrypt('secret'),
            'dni' => '11122233A',
            'tipo_usuario' => 'ALUMNO'
        ]);
        $espacio = $this->crearEspacioValido();

        // act: creamos la reserva y su reserva grupal asociada
        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'user_id' => $user->id,
            'fecha_inicio' => $this->horaInicio,
            'fecha_fin' => $this->horaFin,
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
        $creador = Usuario::create([
            'name' => 'Creador', 'apellidos' => 'Test', 'email' => 'c@test.com',
            'password' => 'secret', 'dni' => '00000001A', 'tipo_usuario' => 'ALUMNO'
        ]);
        $espacio = $this->crearEspacioValido();

        // act: creamos reserva y reserva grupal
        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'user_id' => $creador->id,
            'fecha_inicio' => $this->horaInicio,
            'fecha_fin' => $this->horaFin,
            'estado' => EstadoReserva::PENDIENTE
        ]);

        $grupal = ReservaGrupal::create([
            'reserva_id' => $reserva->id,
            'aforo_max' => 10
        ]);

        // añadimos miembros a la reserva grupal
        $alumno1 = Usuario::create([
            'name' => 'Alumno 1', 'apellidos' => 'Test', 'email' => 'a1@test.com',
            'password' => 'secret', 'dni' => '00000002A', 'tipo_usuario' => 'ALUMNO'
        ]);
        $alumno2 = Usuario::create([
            'name' => 'Alumno 2', 'apellidos' => 'Test', 'email' => 'a2@test.com',
            'password' => 'secret', 'dni' => '00000003A', 'tipo_usuario' => 'ALUMNO'
        ]);

        $grupal->miembros()->attach([$alumno1->id, $alumno2->id]);

        // assert
        $this->assertCount(2, $grupal->miembros);
        $this->assertTrue($grupal->miembros->contains($alumno1));
        $this->assertTrue($grupal->miembros->contains($alumno2));
    }
}
