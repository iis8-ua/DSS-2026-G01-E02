<?php

namespace Tests\Feature;

use App\Models\Historial;
use App\Models\Horario;
use App\Models\Reserva;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class HistorialHorarioRelacionesTest extends TestCase
{
    use RefreshDatabase;

    private function crearUsuarioAlumno(): string
    {
        $userId = (string) Str::uuid();

        DB::table('usuarios')->insert([
            'id' => $userId,
            'nombre' => 'Ada',
            'apellidos' => 'Lovelace',
            'email' => 'ada'.Str::random(6).'@example.com',
            'contrasena' => bcrypt('secret123'), 
            'dni' => 'X'.random_int(10000000, 99999999),
            'tipo_usuario' => \App\Models\Alumno::class,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $userId;
    }

    private function crearEspacio(): string
    {
        $espacioId = (string) Str::uuid();

        DB::table('espacios')->insert([
            'id' => $espacioId,
            'nombre' => 'Aula 101',
            'aforo' => 30,
            'estado' => 'HABILITADO',
            'caracteristicas' => 'Proyector',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $espacioId;
    }

    public function historial_pertenece_a_un_usuario_alumno()
    {
        $userId = $this->crearUsuarioAlumno();

        $historial = Historial::create([
            'user_id' => $userId,
        ]);

        $this->assertNotNull($historial->user);
        $this->assertEquals($userId, $historial->user->id);
    }

    public function historial_tiene_muchas_reservas()
    {
        $userId = $this->crearUsuarioAlumno();
        $espacioId = $this->crearEspacio();

        $historial = Historial::create(['user_id' => $userId]);

        Reserva::create([
            'id' => (string) Str::uuid(),
            'user_id' => $userId,
            'espacio_id' => $espacioId,
            'fecha_inicio' => now()->addDay(),
            'fecha_fin' => now()->addDay()->addHour(),
            'estado' => 'pendiente',
            'historial_id' => $historial->id,
        ]);

        Reserva::create([
            'id' => (string) Str::uuid(),
            'user_id' => $userId,
            'espacio_id' => $espacioId,
            'fecha_inicio' => now()->addDays(2),
            'fecha_fin' => now()->addDays(2)->addHour(),
            'estado' => 'pendiente',
            'historial_id' => $historial->id,
        ]);

        $this->assertCount(2, $historial->reservas()->get());

        $unaReserva = $historial->reservas()->first();
        $this->assertEquals($historial->id, $unaReserva->historial->id);
    }

    public function horario_se_relaciona_con_reservas()
    {
        $userId = $this->crearUsuarioAlumno();
        $espacioId = $this->crearEspacio();

        $horario = Horario::create([
            'inicio' => now()->addDays(3),
            'fin' => now()->addDays(3)->addHours(2),
        ]);

        $reserva = Reserva::create([
            'id' => (string) Str::uuid(),
            'user_id' => $userId,
            'espacio_id' => $espacioId,
            'fecha_inicio' => $horario->inicio,
            'fecha_fin' => $horario->fin,
            'estado' => 'pendiente',
            'horario_id' => $horario->id,
        ]);

        $this->assertCount(1, $horario->reservas()->get());

        $this->assertNotNull($reserva->horario);
        $this->assertEquals($horario->id, $reserva->horario->id);
    }
}