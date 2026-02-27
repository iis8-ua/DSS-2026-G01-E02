<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoEspacio;

class TipoEspacioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoEspacio::create(['nombre' => 'Aula Teoría']);
        TipoEspacio::create(['nombre' => 'Laboratorio']);
        TipoEspacio::create(['nombre' => 'Despacho']);

        TipoEspacio::create(['nombre' => 'Aula Informática']);
        TipoEspacio::create(['nombre' => 'Seminario']);
        TipoEspacio::create(['nombre' => 'Taller']);

        TipoEspacio::create(['nombre' => 'Sala de Estudio']);
        TipoEspacio::create(['nombre' => 'Biblioteca']);
        TipoEspacio::create(['nombre' => 'Cafetería']);

        TipoEspacio::create(['nombre' => 'Sala de Reuniones']);
        TipoEspacio::create(['nombre' => 'Salón de Grados']);
        TipoEspacio::create(['nombre' => 'Salón de Actos']);

        TipoEspacio::create(['nombre' => 'Pabellón Deportivo']);
        TipoEspacio::create(['nombre' => 'Almacén']);
    }
}
