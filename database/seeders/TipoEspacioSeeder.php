<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
    }
}
