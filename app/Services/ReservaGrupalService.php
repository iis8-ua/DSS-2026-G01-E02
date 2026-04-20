<?php

namespace App\Services;

use App\Models\ReservaGrupal;
use Illuminate\Support\Facades\DB;

class ReservaGrupalService {

    public static function crear(array $datos, array $alumnos): ReservaGrupal {
        return DB::transaction(function () use ($datos, $alumnos) {
            $reservaGrupal = ReservaGrupal::create($datos);
            if (!empty($alumnos)) {
                $reservaGrupal->alumnos()->sync($alumnos);
            }
            return $reservaGrupal;
        });
    }

    public static function eliminar(ReservaGrupal $reservaGrupal): void {
        DB::transaction(function () use ($reservaGrupal) {
            $reservaGrupal->alumnos()->detach();
            $reservaGrupal->delete();
        });
    }
}
