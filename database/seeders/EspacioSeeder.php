<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Espacio;
use App\Models\TipoEspacio;
use App\Models\Localizacion;

class EspacioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoLab = TipoEspacio::where('nombre', 'Laboratorio')->first();

        $loc = Localizacion::where('latitud', 40.5)
            ->where('longitud', -3.5)
            ->where('piso', 2)
            ->first();

        if ($tipoLab && $loc) {
            Espacio::create([
                'nombre' => 'Lab de Química',
                'aforo' => 25,
                'estado' => 'HABILITADO',
                'caracteristicas' => 'Mesas ignífugas',

                'tipo_espacio_id' => $tipoLab->id,

                'loc_latitud' => $loc->latitud,
                'loc_longitud' => $loc->longitud,
                'loc_piso' => $loc->piso,

                //hasta que no se implemente horario lo tengo que dejar estatico
                'horario_inicio' => '2024-09-01 08:00:00',
                'horario_fin' => '2024-06-30 15:00:00',
            ]);
        }
    }
}
