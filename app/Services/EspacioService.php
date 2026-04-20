<?php

namespace App\Services;

use App\Models\Espacio;
use Illuminate\Support\Facades\DB;

class EspacioService {

    public static function crear(array $datos, array $horariosIds): Espacio {
        return DB::transaction(function () use ($datos, $horariosIds) {
            $espacio = Espacio::create($datos);
            $espacio->horario()->sync($horariosIds);
            return $espacio;
        });
    }

    public static function actualizar(Espacio $espacio, array $datos, array $horariosIds): Espacio {
        return DB::transaction(function () use ($espacio, $datos, $horariosIds) {
            $espacio->update($datos);
            $espacio->horario()->sync($horariosIds);
            return $espacio;
        });
    }
}
