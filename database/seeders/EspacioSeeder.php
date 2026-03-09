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
                'loc_latitud'     => $locOriginal->latitud,
                'loc_longitud'    => $locOriginal->longitud,
                'loc_piso'        => $locOriginal->piso,
                'horario_inicio'  => $horarios[0]->inicio,
                'horario_fin'     => $horarios[0]->fin,
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
                'loc_latitud'     => $locPlantaBaja->latitud,
                'loc_longitud'    => $locPlantaBaja->longitud,
                'loc_piso'        => $locPlantaBaja->piso,
                'horario_inicio'  => $horarios[1]->inicio,
                'horario_fin'     => $horarios[1]->fin,
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
                'loc_latitud'     => $locAulario->latitud,
                'loc_longitud'    => $locAulario->longitud,
                'loc_piso'        => $locAulario->piso,
                'horario_inicio'  => $horarios[2]->inicio,
                'horario_fin'     => $horarios[2]->fin,
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
                'loc_latitud'     => $locBiblioteca->latitud,
                'loc_longitud'    => $locBiblioteca->longitud,
                'loc_piso'        => $locBiblioteca->piso,
                'horario_inicio'  => $horarios[3]->inicio,
                'horario_fin'     => $horarios[3]->fin,
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
                'loc_latitud'     => $locFacultad->latitud,
                'loc_longitud'    => $locFacultad->longitud,
                'loc_piso'        => $locFacultad->piso,
                'horario_inicio'  => $horarios[4]->inicio,
                'horario_fin'     => $horarios[4]->fin,
                'imagen'          => 'despacho-tutorias.jpg'
            ]);
        }
    }
}
