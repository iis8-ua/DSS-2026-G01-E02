<?php

namespace Tests\Unit;

use App\Models\Alumno;
use App\Models\Espacio;
use App\Models\TipoEspacio;
use App\Models\Localizacion;
use App\Models\Reserva;
use App\Models\ReservaGrupal;
use App\Enums\EstadoReserva;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumnoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test para ver el tipo correcto
     * @test
     */
    public function T01_alumno_creating_should_assign_correct_tipo_usuario()
    {
        //arrange y act
        $alumno = Alumno::create([
            'name' => 'Ada',
            'apellidos' => 'Lovelace',
            'email' => 'ada@example.com',
            'password' => bcrypt('password'),
            'dni' => '12345678A'
        ]);

        //assert
        $this->assertEquals(Alumno::class, $alumno->tipo_usuario);
        $this->assertCount(1, Alumno::all());
    }

    /**
     * Test para la reserva
     * @test
     */
    public function T02_reservar_method_should_create_a_valid_reserva()
    {
        //arrange
        $alumno = Alumno::create([
            'name' => 'Ada',
            'apellidos' => 'Lovelace',
            'email' => 'ada@example.com',
            'password' => bcrypt('password'),
            'dni' => '12345678A'
        ]);

        $tipo = TipoEspacio::create(['nombre' => 'Aula']);
        $loc = Localizacion::create(['latitud' => 1, 'longitud' => 1, 'piso' => 1]);
        $espacio = Espacio::create([
            'nombre' => 'Aula 1', 'aforo' => 10, 'tipo_espacio_id' => $tipo->id, 'localizacion_id' => $loc->id
        ]);

        $hInicio = '2026-03-26 10:00:00';
        $hFin = '2026-03-26 12:00:00';

        //act
        $reserva = $alumno->reservar($espacio, $hInicio, $hFin);

        //assert
        $this->assertInstanceOf(Reserva::class, $reserva);
        $this->assertEquals($alumno->id, $reserva->alumno_id);
        $this->assertEquals($espacio->id, $reserva->espacio_id);
        $this->assertEquals(EstadoReserva::PENDIENTE, $reserva->estado);
        $this->assertDatabaseHas('reservas', ['id' => $reserva->id]);
    }

    /**
     * Test del metodo del historial
     * @test
     */
    public function T03_obtenerHistorial_should_return_reservas_ordered_by_date()
    {
        // Arrange
        $alumno = Alumno::create([
            'name' => 'Ada',
            'apellidos' => 'Lovelace',
            'email' => 'ada@example.com',
            'password' => bcrypt('password'),
            'dni' => '12345678A'
        ]);

        $tipo = TipoEspacio::create(['nombre' => 'Test']);
        $loc = Localizacion::create(['latitud' => 1, 'longitud' => 1, 'piso' => 1]);
        $espacio = Espacio::create(['nombre' => 'E1', 'aforo' => 5, 'tipo_espacio_id' => $tipo->id, 'localizacion_id' => $loc->id]);

        $alumno->reservar($espacio, '2026-01-01 08:00:00', '2026-01-01 09:00:00');
        $alumno->reservar($espacio, '2026-01-02 08:00:00', '2026-01-02 09:00:00');

        //act
        $historial = $alumno->obtenerHistorial();

        //assert
        $this->assertCount(2, $historial);
        $this->assertTrue($historial->first()->hora_inicio->isAfter($historial->last()->hora_inicio));
    }

    /**
     * Test de la relación con reservas grupales
     * @test
     */
    public function T04_alumno_can_belong_to_many_reservas_grupales()
    {
        //arrange
        $alumno = Alumno::create([
            'name' => 'Ada',
            'apellidos' => 'Lovelace',
            'email' => 'ada@example.com',
            'password' => bcrypt('password'),
            'dni' => '12345678A'
        ]);
        $propietario = Alumno::create([
            'name' => 'Prop',
            'apellidos' => 'Garcia',
            'email' => 'prop@example.com',
            'password' => bcrypt('password'),
            'dni' => '12345678B'
        ]);

        $tipo = TipoEspacio::create(['nombre' => 'Lab']);
        $loc = Localizacion::create(['latitud' => 1, 'longitud' => 1, 'piso' => 1]);
        $espacio = Espacio::create(['nombre' => 'L1', 'aforo' => 20, 'tipo_espacio_id' => $tipo->id, 'localizacion_id' => $loc->id]);

        $reservaBase = $propietario->reservar($espacio, '2026-05-01 10:00:00', '2026-05-01 12:00:00');
        $grupal = ReservaGrupal::create(['reserva_id' => $reservaBase->id, 'aforo_max' => 10]);

        //act
        $grupal->addAlumno($alumno);

        //assert
        $this->assertCount(1, $alumno->reservasGrupales);
        $this->assertTrue($alumno->reservasGrupales->contains($grupal));
    }
}
