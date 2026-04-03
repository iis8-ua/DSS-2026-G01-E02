<?php

namespace Tests\Unit;

use App\Enums\EstadoReserva;
use App\Models\Alumno;
use App\Models\Espacio;
use App\Models\Horario;
use App\Models\Localizacion;
use App\Models\Reserva;
use App\Models\ReservaGrupal;
use App\Models\TipoEspacio;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservaGrupalTest extends TestCase
{
    // para limpiar la base de datos tras cada test
    use RefreshDatabase;

    private $horaInicio = '2026-03-26 08:00:00';
    private $horaFin = '2026-03-26 10:00:00';

    // misma función que en la Reserva para crear un espacio válido
    private function crearEspacioValido(){
        $tipo = TipoEspacio::create(['nombre' => 'Aula']);
        $loc = Localizacion::create(['latitud' => 1.0, 'longitud' => 1.0, 'piso' => 1]);

        return Espacio::create([
            'nombre'          => 'Aula Magna',
            'aforo'           => 50,
            'estado'          => 'HABILITADO',
            'tipo_espacio_id' => $tipo->id,
            'localizacion_id' => $loc->id,
        ]);
    }

    // test para comprobar que una resrva grupal pertenece a una reserva base

    /**
     * @test
     */
    public function test_reserva_grupal_pertenece_a_una_reserva_base(){
        // arrange: creamos usuario y espacio
        $alumno = Alumno::create([
            'name' => 'Juan',
            'apellidos' => 'Pruebas',
            'email' => 'juan@test.com',
            'password' => bcrypt('secret'),
            'dni' => '11122233A',
            'tipo_usuario' => 'ALUMNO'
        ]);
        $espacio = $this->crearEspacioValido();

        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'alumno_id' => $alumno->id,
            'hora_inicio' => $this->horaInicio,
            'hora_fin' => $this->horaFin,
            'estado' => EstadoReserva::PENDIENTE
        ]);

        //act
        $grupal = ReservaGrupal::create([
            'reserva_id' => $reserva->id,
            'aforo_max' => 10
        ]);

        // arrange
        $this->assertInstanceOf(Reserva::class, $grupal->reserva);
        $this->assertEquals($reserva->id, $grupal->reserva->id);
    }

    /**
     * @test
     */
    public function test_reserva_grupal_tiene_multiples_miembros(){
        // arrange: creamos usuaro y espacio
        $alumno = Alumno::create([
            'name' => 'Creador', 'apellidos' => 'Test', 'email' => 'c@test.com',
            'password' => 'secret', 'dni' => '00000001A', 'tipo_usuario' => 'ALUMNO'
        ]);
        $espacio = $this->crearEspacioValido();

        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'alumno_id' => $alumno->id,
            'hora_inicio' => $this->horaInicio,
            'hora_fin' => $this->horaFin,
            'estado' => EstadoReserva::PENDIENTE
        ]);

        $grupal = ReservaGrupal::create([
            'reserva_id' => $reserva->id,
            'aforo_max' => 10
        ]);

        // añadimos miembros a la reserva grupal
        $alumno1 = Alumno::create([
            'name' => 'Alumno 1', 'apellidos' => 'Test', 'email' => 'a1@test.com',
            'password' => 'secret', 'dni' => '00000002A', 'tipo_usuario' => 'ALUMNO'
        ]);
        $alumno2 = Alumno::create([
            'name' => 'Alumno 2', 'apellidos' => 'Test', 'email' => 'a2@test.com',
            'password' => 'secret', 'dni' => '00000003A', 'tipo_usuario' => 'ALUMNO'
        ]);

        //act
        $grupal->addAlumno($alumno1);
        $grupal->addAlumno($alumno2);

        // assert
        $this->assertCount(2, $grupal->alumnos);
        $this->assertTrue($grupal->alumnos->contains($alumno1));
        $this->assertTrue($grupal->alumnos->contains($alumno2));
    }

    /**
     * @test
     */
    public function test_reserva_grupal_elimina_alumno(){
        //arrange
        $alumno = Alumno::create([
            'name' => 'Creador', 'apellidos' => 'Test', 'email' => 'c@test.com',
            'password' => 'secret', 'dni' => '00000001A', 'tipo_usuario' => 'ALUMNO'
        ]);

        $espacio = $this->crearEspacioValido();
        $reserva = Reserva::create([
            'espacio_id' => $espacio->id, 'alumno_id' => $alumno->id,
            'hora_inicio' => $this->horaInicio, 'hora_fin' => $this->horaFin, 'estado' => EstadoReserva::PENDIENTE
        ]);
        $grupal = ReservaGrupal::create(['reserva_id' => $reserva->id, 'aforo_max' => 5]);

        //act
        $grupal->removeAlumno($alumno);

        //assert
        $this->assertCount(0, $grupal->alumnos->fresh());
    }
}
