<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Localizacion;

class LocalizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Localizacion::create(['latitud' => 40.5, 'longitud' => -3.5, 'piso' => -1]);
        Localizacion::create(['latitud' => 40.5, 'longitud' => -3.5, 'piso' => 0]);
        Localizacion::create(['latitud' => 40.5, 'longitud' => -3.5, 'piso' => 1]);
        Localizacion::create(['latitud' => 40.5, 'longitud' => -3.5, 'piso' => 2]);
        Localizacion::create(['latitud' => 40.5, 'longitud' => -3.5, 'piso' => 3]);
        Localizacion::create(['latitud' => 40.5, 'longitud' => -3.5, 'piso' => 4]);


        Localizacion::create(['latitud' => 40.501, 'longitud' => -3.502, 'piso' => 0]);
        Localizacion::create(['latitud' => 40.501, 'longitud' => -3.502, 'piso' => 1]);
        Localizacion::create(['latitud' => 40.501, 'longitud' => -3.502, 'piso' => 2]);
        Localizacion::create(['latitud' => 40.501, 'longitud' => -3.502, 'piso' => 3]);


        Localizacion::create(['latitud' => 40.505, 'longitud' => -3.495, 'piso' => -1]);
        Localizacion::create(['latitud' => 40.505, 'longitud' => -3.495, 'piso' => 0]);
        Localizacion::create(['latitud' => 40.505, 'longitud' => -3.495, 'piso' => 1]);
        Localizacion::create(['latitud' => 40.505, 'longitud' => -3.495, 'piso' => 2]);


        Localizacion::create(['latitud' => 41.0, 'longitud' => -2.0, 'piso' => 0]);
        Localizacion::create(['latitud' => 41.0, 'longitud' => -2.0, 'piso' => 1]);
        Localizacion::create(['latitud' => 41.0, 'longitud' => -2.0, 'piso' => 2]);


        Localizacion::create(['latitud' => 40.498, 'longitud' => -3.508, 'piso' => 0]);
        Localizacion::create(['latitud' => 40.498, 'longitud' => -3.508, 'piso' => 1]);
    }
}
