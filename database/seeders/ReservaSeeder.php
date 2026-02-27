<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Reserva;
use App\Models\ReservaGrupal;
use App\Models\Usuario;
use App\Models\Espacio;
use App\Enums\EstadoReserva;

class ReservaSeeder extends Seeder
{
    public function run(): void
    {
        $alumnos = Usuario::where('tipo_usuario', 'ALUMNO')->get();
        $espacios = Espacio::all();

        if ($alumnos->count() >= 2 && $espacios->count() >= 5) {

            $alumno1 = $alumnos[0];
            $alumno2 = $alumnos[1];

            $labQuimica = $espacios[0];
            $aulaMagna = $espacios[1];
            $salaEstudio = $espacios[3];

            $reserva1 = Reserva::create([
                'espacio_id'   => $labQuimica->id,
                'user_id'      => $alumno1->id,
                'fecha_inicio' => $labQuimica->horario_inicio,
                'fecha_fin'    => $labQuimica->horario_fin,
                'estado'       => EstadoReserva::ACEPTADA,
            ]);

            ReservaGrupal::create([
                'reserva_id' => $reserva1->id,
                'aforo_max'  => 20,
            ]);

            DB::table('reserva_grupal_user')->insert([
                ['reserva_grupal_id' => $reserva1->id, 'user_id' => $alumno2->id, 'created_at' => now(), 'updated_at' => now()]
            ]);

            Reserva::create([
                'espacio_id'   => $salaEstudio->id,
                'user_id'      => $alumno2->id,
                'fecha_inicio' => $salaEstudio->horario_inicio,
                'fecha_fin'    => $salaEstudio->horario_fin,
                'estado'       => EstadoReserva::PENDIENTE,
            ]);

            $reserva3 = Reserva::create([
                'espacio_id'   => $aulaMagna->id,
                'user_id'      => $alumno1->id,
                'fecha_inicio' => $aulaMagna->horario_inicio,
                'fecha_fin'    => $aulaMagna->horario_fin,
                'estado'       => EstadoReserva::RECHAZADA,
            ]);

            ReservaGrupal::create([
                'reserva_id' => $reserva3->id,
                'aforo_max'  => 100,
            ]);

            DB::table('reserva_grupal_user')->insert([
                'reserva_grupal_id' => $reserva3->id,
                'user_id' => $alumno2->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        }
    }
}
