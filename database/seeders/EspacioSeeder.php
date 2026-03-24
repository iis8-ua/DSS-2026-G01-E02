<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Espacio;
use App\Models\TipoEspacio;
use App\Models\Localizacion;
use App\Models\Horario;

class EspacioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $horarios = Horario::all();

        $tipoLab         = TipoEspacio::where('nombre', 'Laboratorio')->first();
        $tipoAula        = TipoEspacio::where('nombre', 'Aula Teoría')->first();
        $tipoDespacho    = TipoEspacio::where('nombre', 'Despacho')->first();
        $tipoInformatica = TipoEspacio::where('nombre', 'Aula Informática')->first();
        $tipoSalaEstudio = TipoEspacio::where('nombre', 'Sala de Estudio')->first();
        $tipoDeportes    = TipoEspacio::firstOrCreate(['nombre' => 'Instalación Deportiva']);

        $locOriginal   = Localizacion::where('latitud', 40.5)->where('longitud', -3.5)->where('piso', 2)->first();
        $locPlantaBaja = Localizacion::where('latitud', 40.5)->where('longitud', -3.5)->where('piso', 0)->first();
        $locFacultad   = Localizacion::where('latitud', 40.501)->where('longitud', -3.502)->where('piso', 1)->first();
        $locBiblioteca = Localizacion::where('latitud', 40.505)->where('longitud', -3.495)->where('piso', 1)->first();
        $locAulario    = Localizacion::where('latitud', 41.0)->where('longitud', -2.0)->where('piso', 1)->first();

        if ($tipoLab && $locOriginal) {
            Espacio::create([
                'nombre'          => 'Lab de Química',
                'aforo'           => 25,
                'estado'          => 'HABILITADO',
                'caracteristicas' => 'Mesas ignífugas, campana extractora',
                'tipo_espacio_id' => $tipoLab->id,
                'localizacion_id' => $locOriginal->id,
                'horario_id'      => $horarios[0]->id,
                'imagen'          => 'lab-quimica.jpg'
            ]);
        }

        if ($tipoAula && $locPlantaBaja) {
            Espacio::create([
                'nombre'          => 'Aula Magna',
                'aforo'           => 150,
                'estado'          => 'HABILITADO',
                'caracteristicas' => 'Proyector 4K, microfonía, enchufes en mesas',
                'tipo_espacio_id' => $tipoAula->id,
                'localizacion_id' => $locPlantaBaja->id,
                'horario_id'      => $horarios[1]->id,
                'imagen'          => 'aula-magna.jpg'
            ]);
        }

        if ($tipoInformatica && $locAulario) {
            Espacio::create([
                'nombre'          => 'Aula Info 1.1',
                'aforo'           => 30,
                'estado'          => 'HABILITADO',
                'caracteristicas' => '30 PCs Windows, software de diseño',
                'tipo_espacio_id' => $tipoInformatica->id,
                'localizacion_id' => $locAulario->id,
                'horario_id'      => $horarios[2]->id,
                'imagen'          => 'aula-info.jpg'
            ]);
        }

        if ($tipoSalaEstudio && $locBiblioteca) {
            Espacio::create([
                'nombre'          => 'Sala de Estudio Silenciosa',
                'aforo'           => 80,
                'estado'          => 'HABILITADO',
                'caracteristicas' => 'Aislamiento acústico, flexos individuales',
                'tipo_espacio_id' => $tipoSalaEstudio->id,
                'localizacion_id' => $locBiblioteca->id,
                'horario_id'      => $horarios[3]->id,
                'imagen'          => 'sala-estudio.jpg'
            ]);
        }

        if ($tipoDespacho && $locFacultad) {
            Espacio::create([
                'nombre'          => 'Despacho Tutorías Ciencias',
                'aforo'           => 4,
                'estado'          => 'HABILITADO',
                'caracteristicas' => 'Mesa de reuniones pequeña, pizarra blanca',
                'tipo_espacio_id' => $tipoDespacho->id,
                'localizacion_id' => $locFacultad->id,
                'horario_id'      => $horarios[4]->id,
                'imagen'          => 'despacho-tutorias.jpg'
            ]);
        }

        $nuevosEspacios = [
            [
                'nombre' => 'Gimnasio', 'aforo' => 100, 'estado' => 'DESHABILITADO',
                'caracteristicas' => 'Material sintético, de 33 x 13 m, altura de 3,5 m. Gimnasio de musculación con todo tipo de aparatos...',
                'imagen' => '1773753644_gym-ua.jpg', 'lat' => 40.5, 'lon' => -3.5, 'piso' => -1
            ],
            [
                'nombre' => 'Campo de fútbol', 'aforo' => 22, 'estado' => 'HABILITADO',
                'caracteristicas' => 'Hierba artificial, de 120 x 65 m, con iluminación. 1 campo de fútbol 11 / rugby, o 2 de fútbol 8',
                'imagen' => '1773753885_futbol-ua.jpg', 'lat' => 40.498, 'lon' => -3.508, 'piso' => 0
            ],
            [
                'nombre' => 'Campo de hockey', 'aforo' => 12, 'estado' => 'HABILITADO',
                'caracteristicas' => 'Hierba artificial, de 90 x 55 m, con iluminación',
                'imagen' => '1773753972_hockey-ua.jpg', 'lat' => 40.501, 'lon' => -3.502, 'piso' => 0
            ],
            [
                'nombre' => 'Pista semicubierta', 'aforo' => 10, 'estado' => 'HABILITADO',
                'caracteristicas' => 'Material sintético, de 44 x 22 m, con iluminación. Fútbol sala, baloncesto, balonmano y hockey sala',
                'imagen' => '1773754042_semicubierta-ua.jpg', 'lat' => 41.0, 'lon' => -2.0, 'piso' => 0
            ],
            [
                'nombre' => 'Pista de pádel', 'aforo' => 4, 'estado' => 'HABILITADO',
                'caracteristicas' => '3 pistas de hierba artificial, de 20 x 10 m, con iluminación',
                'imagen' => '1773754091_padel-ua.jpg', 'lat' => 40.505, 'lon' => -3.495, 'piso' => 0
            ],
            [
                'nombre' => 'Pista de tenis', 'aforo' => 4, 'estado' => 'HABILITADO',
                'caracteristicas' => '3 pistas de hormigón pulido, de 36 x 18 m, con iluminación',
                'imagen' => '1773754160_tenis-ua.jpg', 'lat' => 40.5, 'lon' => -3.5, 'piso' => 1
            ],
            [
                'nombre' => 'Pista de atletismo', 'aforo' => 6, 'estado' => 'HABILITADO',
                'caracteristicas' => 'Material sintético, de 400 m y 8 calles, con iluminación',
                'imagen' => '1773754256_atletismo-ua.jpg', 'lat' => 40.505, 'lon' => -3.495, 'piso' => -1
            ],
            [
                'nombre' => 'Pista de baloncesto', 'aforo' => 10, 'estado' => 'HABILITADO',
                'caracteristicas' => 'Material sintético, de 32 x 16 m, con iluminación',
                'imagen' => '1773754309_baloncesto-ua.jpg', 'lat' => 40.498, 'lon' => -3.508, 'piso' => 1
            ],
            [
                'nombre' => 'Pista de voley playa', 'aforo' => 4, 'estado' => 'HABILITADO',
                'caracteristicas' => 'Arena de sílice, de 24 x 12 m, con iluminación',
                'imagen' => '1773754372_voley-playa-ua.jpg', 'lat' => 40.501, 'lon' => -3.502, 'piso' => 2
            ],
            [
                'nombre' => 'Vestuarios semicubierta', 'aforo' => 25, 'estado' => 'HABILITADO',
                'caracteristicas' => '16 vestuarios: 6 de 52,50 m2, 4 de 120,00 m2, 4 de 12,50 m2 y 2 de 6,55 m2 (discapacitados)',
                'imagen' => '1773754430_vestuarios-semicubierta-ua.jpg', 'lat' => 40.5, 'lon' => -3.5, 'piso' => 4
            ],
            [
                'nombre' => 'Circuito natural', 'aforo' => 200, 'estado' => 'HABILITADO',
                'caracteristicas' => 'Pista de arena de unos 700 m y aparatos de gimnasia',
                'imagen' => '1773754490_circuito-natural-ua.jpg', 'lat' => 40.501, 'lon' => -3.502, 'piso' => 3
            ]
        ];

        foreach ($nuevosEspacios as $index => $datos) {

            $loc = Localizacion::where('latitud', $datos['lat'])
                    ->where('longitud', $datos['lon'])
                    ->where('piso', $datos['piso'])
                    ->firstOrCreate([
                        'latitud'  => $datos['lat'],
                        'longitud' => $datos['lon'],
                        'piso'     => $datos['piso']
                    ]);

            $horario = $horarios[$index % $horarios->count()];

            Espacio::create([
                'nombre'          => $datos['nombre'],
                'aforo'           => $datos['aforo'],
                'estado'          => $datos['estado'],
                'caracteristicas' => $datos['caracteristicas'],
                'tipo_espacio_id' => $tipoDeportes->id,
                'localizacion_id' => $loc->id,
                'horario_id'      => $horario->id,
                'imagen'          => $datos['imagen']
            ]);
        }
    }
}
