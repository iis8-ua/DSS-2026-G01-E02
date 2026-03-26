<?php

namespace Tests\Unit;

use App\Enums\EstadoReserva;
use App\Models\Espacio;
use App\Models\Horario;
use App\Models\Localizacion;
use App\Models\Reserva;
use App\Models\ReservaGrupal;
use App\Models\TipoEspacio;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservaTest extends TestCase
{
    // para limpiar la base de datos tras cada test
    use RefreshDatabase;

    private $hInicio = '08:00:00';
    private $hFin = '10:00:00';

    // Función auxiliar para crear un espacio válido
    private function crearEspacioValido()
    {
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

    private function crearUsuarioTest() {
        return Usuario::create([
            'name' => 'Juan',
            'apellidos' => 'Test',
            'email' => 'test' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
            'dni' => rand(10000000, 99999999) . 'Z',
            'tipo_usuario' => 'ALUMNO'
        ]);
    }

    // test para comprobar que una reserva pertenece a un usuario
    /**
     * @test
     */
    public function test_reserva_pertenece_a_un_usuario(){
        // Arrange
        // creamos un usuario y un espacio para la reserva
        $alumno = $this->crearUsuarioTest();
        $espacio = $this->crearEspacioValido();

        // Act
        $reserva = Reserva::create([
            'espacio_id'  => $espacio->id,
            'alumno_id'   => $alumno->id,
            'hora_inicio' => $this->hInicio,
            'hora_fin'    => $this->hFin,
            'estado'      => EstadoReserva::PENDIENTE
        ]);

        // assert
        $this->assertInstanceOf(Usuario::class, $reserva->alumno);
        $this->assertEquals($alumno->id, $reserva->alumno->id);
    }

    // test para comrpobar que una reserva está asociada a un espacio

    /**
     * @test
     */
    public function test_reserva_pertenece_a_un_espacio(){
        // arrange: usuario y espacio
        $alumno = $this->crearUsuarioTest();
        $espacio = $this->crearEspacioValido();

        // act
        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'alumno_id' => $alumno->id,
            'hora_inicio' => $this->hInicio,
            'hora_fin' => $this->hFin,
            'estado' => EstadoReserva::PENDIENTE
        ]);

        // assert
        $this->assertInstanceOf(Espacio::class, $reserva->espacio);
        $this->assertEquals($espacio->id, $reserva->espacio->id);
    }

    // test para comprobar que una reserva es una reserva grupal

    /**
     * @test
     */
    public function test_reserva_cambia_estado_a_cancelada(){
        // arrange: usuario y espacio
        $alumno = $this->crearUsuarioTest();
        $espacio = $this->crearEspacioValido();

        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'alumno_id' => $alumno->id,
            'hora_inicio' => $this->hInicio,
            'hora_fin' => $this->hFin,
            'estado' => EstadoReserva::PENDIENTE
        ]);

        // act: crear la reserva y su reserva grupal
        $reserva->cancelar();

        // assert
        $this->assertEquals(EstadoReserva::CANCELADA, $reserva->fresh()->estado);
    }

    /**
     * @test
     */
    public function test_reserva_cambia_estado_a_aceptada(){
        //arrange
        $alumno = $this->crearUsuarioTest();
        $espacio = $this->crearEspacioValido();

        $reserva = Reserva::create([
            'espacio_id'  => $espacio->id,
            'alumno_id'   => $alumno->id,
            'hora_inicio' => $this->hInicio,
            'hora_fin'    => $this->hFin,
            'estado'      => EstadoReserva::PENDIENTE
        ]);

        //act
        $reserva->abrirReserva();

        //assert
        $this->assertEquals(EstadoReserva::ACEPTADA, $reserva->fresh()->estado);
    }
}
