<?php

namespace Tests\Unit;

use App\Models\GestorEspacios;
use App\Models\Reserva;
use App\Models\Usuario;
use App\Models\Alumno;
use App\Models\Espacio;
use App\Models\TipoEspacio;
use App\Models\Localizacion;
use App\Enums\EstadoReserva;
use App\Enums\EstadoEspacio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GestorEspaciosTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test para creacion
     * @test
     */
    public function T01_gestor_espacios_creating_should_assign_correct_tipo_usuario()
    {
        //arrange y act
        $gestor = GestorEspacios::create([
            'name' => 'Carlos',
            'apellidos' => 'Admin',
            'email' => 'carlos@test.com',
            'password' => bcrypt('password'),
            'dni' => '99988877G'
        ]);

        //assert
        $this->assertEquals(GestorEspacios::class, $gestor->tipo_usuario);
        $this->assertCount(1, GestorEspacios::all());
        Usuario::create([
            'name' => 'Usuario',
            'apellidos' => 'Normal',
            'email' => 'u@test.com',
            'password' => bcrypt('password'),
            'dni' => '11122233K',
            'tipo_usuario' => 'usuario'
        ]);
        $this->assertCount(1, GestorEspacios::all());
    }

    /**
     * Test para aceptar la reserva
     * @test
     */
    public function T02_aceptarReserva_should_change_status_to_aceptada()
    {
        //arrange
        $gestor = GestorEspacios::create([
            'name' => 'Carlos',
            'apellidos' => 'Admin',
            'email' => 'carlos@test.com',
            'password' => bcrypt('password'),
            'dni' => '99988877G'
        ]);

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
            'nombre' => 'Aula 1', 'aforo' => 10, 'tipo_espacio_id' => $tipo->id, 'localizacion_id' => $loc->id, 'estado' => EstadoEspacio::HABILITADO
        ]);

        $reserva = Reserva::create([
            'alumno_id' => $alumno->id,
            'espacio_id' => $espacio->id,
            'hora_inicio' => '2026-03-26 10:00:00',
            'hora_fin' => '2026-03-26 11:00:00',
            'estado' => EstadoReserva::PENDIENTE
        ]);

        //act
        $gestor->aceptarReserva($reserva);

        //assert
        $this->assertEquals(EstadoReserva::ACEPTADA, $reserva->fresh()->estado);
    }

    /**
     * Test del rechazar la reserva
     * @test
     */
    public function T03_rechazarReserva_should_change_status_to_rechazada()
    {
        //arrange
        $gestor = GestorEspacios::create([
            'name' => 'Carlos',
            'apellidos' => 'Admin',
            'email' => 'carlos@test.com',
            'password' => bcrypt('password'),
            'dni' => '99988877G'
        ]);

        $alumno = Alumno::create([
            'name' => 'Ada',
            'apellidos' => 'Lovelace',
            'email' => 'ada@example.com',
            'password' => bcrypt('password'),
            'dni' => '12345678A'
        ]);

        $tipo = TipoEspacio::create(['nombre' => 'Lab']);
        $loc = Localizacion::create(['latitud' => 1, 'longitud' => 1, 'piso' => 1]);
        $espacio = Espacio::create([
            'nombre' => 'Lab 1', 'aforo' => 5, 'tipo_espacio_id' => $tipo->id, 'localizacion_id' => $loc->id, 'estado' => EstadoEspacio::HABILITADO
        ]);

        $reserva = Reserva::create([
            'alumno_id' => $alumno->id,
            'espacio_id' => $espacio->id,
            'hora_inicio' => '2026-03-26 12:00:00',
            'hora_fin' => '2026-03-26 13:00:00',
            'estado' => EstadoReserva::PENDIENTE
        ]);

        //act
        $gestor->rechazarReserva($reserva);

        //assert
        $this->assertEquals(EstadoReserva::RECHAZADA, $reserva->fresh()->estado);
    }
}
