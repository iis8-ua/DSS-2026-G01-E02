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
                'alumno_id'      => $alumno1->id,
                'hora_inicio' => '2026-09-01 08:00:00',
                'hora_fin'    => '2026-09-01 10:00:00',
                'estado'       => EstadoReserva::ACEPTADA,
            ]);

            $reservaGrupal1 = ReservaGrupal::create([
                'reserva_id' => $reserva1->id,
                'aforo_max'  => 20,
            ]);

            $reservaGrupal1->addAlumno($alumno2);

            Reserva::create([
                'espacio_id'   => $salaEstudio->id,
                'alumno_id'      => $alumno2->id,
                'hora_inicio' => '2026-09-02 16:00:00',
                'hora_fin'    => '2026-09-02 20:00:00',
                'estado'       => EstadoReserva::PENDIENTE,
            ]);

            $reserva3 = Reserva::create([
                'espacio_id'   => $aulaMagna->id,
                'alumno_id'      => $alumno1->id,
                'hora_inicio' => '2026-09-05 17:00:00',
                'hora_fin'    => '2026-09-05 20:00:00',
                'estado'       => EstadoReserva::RECHAZADA,
            ]);

            $reservaGrupal2= ReservaGrupal::create([
                'reserva_id' => $reserva3->id,
                'aforo_max'  => 100,
            ]);

            $reservaGrupal2->addAlumno($alumno2);

        }
    }
}
