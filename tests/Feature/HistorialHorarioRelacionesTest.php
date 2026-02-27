<?php

namespace Tests\Feature;

use App\Enums\EstadoEspacio;
use App\Enums\EstadoReserva;
use App\Models\Historial;
use App\Models\Horario;
use App\Models\Reserva;
use App\Models\Usuario;
use App\Models\Espacio;
use App\Models\TipoEspacio;
use App\Models\Localizacion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class HistorialHorarioRelacionesTest extends TestCase
{
    use RefreshDatabase;

    private $hInicio = '08:00:00';
    private $hFin = '10:00:00';

    private function crearUsuarioAlumno(): Usuario
    {
        return Usuario::create([
            'name' => 'Ada',
            'apellidos' => 'Lovelace',
            'email' => 'ada'.Str::random(6).'@example.com',
            'password' => bcrypt('secret123'),
            'dni' => 'X'.random_int(10000000, 99999999),
            'tipo_usuario' => 'ALUMNO'
        ]);

    }

    private function crearEspacio(): Espacio
    {
        $tipo = TipoEspacio::create(['nombre' => 'Teoría']);
        $loc = Localizacion::create(['latitud' => rand(1,100), 'longitud' => rand(1,100), 'piso' => 1]);

        $hor=Horario::create(['inicio' => $this->hInicio, 'fin' => $this->hFin]);

        return Espacio::create([
            'nombre' => 'Aula 101',
            'aforo' => 30,
            'tipo_espacio_id' => $tipo->id,
            'loc_latitud' => $loc->latitud,
            'loc_longitud' => $loc->longitud,
            'loc_piso' => $loc->piso,
            'horario_inicio' => $hor->inicio,
            'horario_fin' => $hor->fin,
            'estado' => EstadoEspacio::HABILITADO,
        ]);
    }

    /**
     * @test
     */
    public function historial_pertenece_a_un_usuario_alumno()
    {
        $user = $this->crearUsuarioAlumno();

        $historial = Historial::create([
            'user_id' => $user->id,
        ]);

        $this->assertNotNull($historial->usuario);
        $this->assertInstanceOf(Usuario::class, $historial->usuario);
        $this->assertEquals($user->id, $historial->usuario->id);
    }

    /**
     * @test
     */
    public function historial_tiene_muchas_reservas()
    {
        $user = $this->crearUsuarioAlumno();
        $espacio = $this->crearEspacio();
        $historial = Historial::create(['user_id' => $user->id]);

        Reserva::create([
            'user_id' => $user->id,
            'espacio_id' => $espacio->id,
            'fecha_inicio' => $this->hInicio,
            'fecha_fin' => $this->hFin,
            'estado' => EstadoReserva::PENDIENTE,
        ]);

        Reserva::create([
            'user_id' => $user->id,
            'espacio_id' => $espacio->id,
            'fecha_inicio' => $this->hInicio,
            'fecha_fin' => $this->hFin,
            'estado' => EstadoReserva::PENDIENTE,
        ]);

        $this->assertCount(2, $user->reservas);
    }

    /**
     * @test
     */
    public function horario_se_relaciona_con_reservas()
    {
        $user = $this->crearUsuarioAlumno();
        $espacio = $this->crearEspacio();

        // El horario ya se creó en crearEspacio()
        $horario =Horario::first();

        $reserva = Reserva::create([
            'user_id' => $user->id,
            'espacio_id' => $espacio->id,
            'fecha_inicio' => $horario->inicio,
            'fecha_fin' => $horario->fin,
            'estado' => EstadoReserva::PENDIENTE,
        ]);

        $this->assertCount(1, $horario->reservas()->get());
        $this->assertNotNull($reserva->horario);
        $this->assertEquals($horario->id, $reserva->horario->id);
    }
}
