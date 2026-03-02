<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Espacio;
use App\Models\TipoEspacio;
use App\Models\Localizacion;
use App\Models\Horario;
use App\Enums\EstadoEspacio;

//En esta clase de test de Espacio se van a probar que las relaciones implementadas funcionen correctamente
class EspacioTest extends TestCase
{
    //Para que la base de datos se limpie y no se queden las cosas despues de los test
    use RefreshDatabase;

    /**
     * Test de la relacion con TipoEspacio
     * @test
     */
    public function T01_tipo_should_return_TipoEspacio_when_espacio_has_tipo_id()
    {
        //Arrange
        $tipo = TipoEspacio::create([
            'nombre' => 'Laboratorio'
        ]);

        //para que no falle el espacio
        $loc = Localizacion::create([
            'latitud' => 10.0, 'longitud' => 10.0, 'piso' => 1
        ]);

        $hor= Horario::create(['inicio' => '08:00:00', 'fin' => '10:00:00']);

        $espacio = Espacio::create([
            'nombre' => 'Lab Química',
            'aforo' => 20,
            'tipo_espacio_id' => $tipo->id,
            'loc_latitud' => $loc->latitud,
            'loc_longitud' => $loc->longitud,
            'loc_piso' => $loc->piso,
            'horario_inicio' => $hor->inicio,
            'horario_fin' => $hor->fin,
        ]);
        //Act
        $resultado=$espacio->tipo;

        //Assert
        $this->assertInstanceOf(TipoEspacio::class, $resultado);
        $this->assertEquals($tipo->id, $resultado->id);
    }

    /**
     * Test para la relacion con Localización
     * @test
     */
    public function T02_localizacion_should_return_Localizacion_when_espacio_has_loc_keys(){
        //Arrange
        $localizacion = Localizacion::create([
            'latitud' => 40.5,
            'longitud' => -3.5,
            'piso' => 2,
        ]);

        $tipo = TipoEspacio::create(['nombre' => 'Aula']);
        $hor= Horario::create(['inicio' => '08:00:00', 'fin' => '10:00:00']);

        $espacio = Espacio::create([
            'nombre' => 'Aula Magna',
            'aforo' => 50,
            'tipo_espacio_id' => $tipo->id,
            'loc_latitud' => $localizacion->latitud,
            'loc_longitud' => $localizacion->longitud,
            'loc_piso' => $localizacion->piso,
            'horario_inicio' => $hor->inicio,
            'horario_fin' => $hor->fin,
        ]);

        //Act
        $resultado=$espacio->localizacion;

        //Assert
        $this->assertInstanceOf(Localizacion::class, $resultado);
        $this->assertEquals($localizacion->latitud, $resultado->latitud);
        $this->assertEquals($localizacion->longitud, $resultado->longitud);
        $this->assertEquals($localizacion->piso, $resultado->piso);
    }

    /**
     * Test de la relacion con Horario
     * @test
     */
    public function T03_horario_should_return_Horario_when_espacio_has_horario_dates(){
        //Arrange
        $tipo = TipoEspacio::create(['nombre' => 'Despacho']);
        $loc = Localizacion::create(['latitud' => 5.0, 'longitud' => 5.0, 'piso' => 0]);
        $horario = Horario::create(['inicio' => '09:00:00', 'fin' => '14:00:00']);

        $espacio = Espacio::create([
            'nombre' => 'Despacho 1',
            'aforo' => 2,
            'tipo_espacio_id' => $tipo->id,
            'loc_latitud' => $loc->latitud,
            'loc_longitud' => $loc->longitud,
            'loc_piso' => $loc->piso,
            'horario_inicio' => $horario->inicio,
            'horario_fin' => $horario->fin,
        ]);


        //Act
        $resultado=$espacio->horario;

        //Assert
        $this->assertInstanceOf(Horario::class, $resultado);
        $this->assertEquals($horario->inicio, $resultado->inicio);
        $this->assertEquals($horario->fin, $resultado->fin);
    }

    /**
     * Test para ver que un espacio no puede estar en la misma localizacion
     * @test
     */
    public function T04_crear_should_throwException_when_localizacion_is_duplicated()
    {
        //Arrange
        $loc = Localizacion::create(['latitud' => 1.0, 'longitud' => 1.0, 'piso' => 1]);
        $tipo = TipoEspacio::create(['nombre' => 'Tipo A']);

        $hor1=Horario::create(['inicio' => '08:00:00', 'fin' => '10:00:00']);
        $hor2=Horario::create(['inicio' => '12:00:00', 'fin' => '14:00:00']);

        Espacio::create([
            'nombre' => 'Espacio 1',
            'aforo' => 10,
            'tipo_espacio_id' => $tipo->id,
            'loc_latitud' => $loc->latitud,
            'loc_longitud' => $loc->longitud,
            'loc_piso' => $loc->piso,
            'horario_inicio' => $hor1->inicio,
            'horario_fin' => $hor1->fin,
        ]);

        //Assert
        $this->expectException(\Illuminate\Database\QueryException::class);

        //act
        Espacio::create([
            'nombre' => 'Espacio 2',
            'aforo' => 10,
            'tipo_espacio_id' => $tipo->id,
            'loc_latitud' => $loc->latitud,
            'loc_longitud' => $loc->longitud,
            'loc_piso' => $loc->piso,
            'horario_inicio' => $hor2->inicio,
            'horario_fin' => $hor2->fin,
        ]);
    }

    /**
     * Test que prueba que el tipo de espacio no es nulo
     * @test
     */
    public function T05_crear_should_throwException_when_tipoEspacio_is_null()
    {
        //Arrange
        $loc = Localizacion::create(['latitud' => 2.0, 'longitud' => 2.0, 'piso' => 1]);
        $hor=Horario::create(['inicio' => '08:00:00', 'fin' => '10:00:00']);

        //Assert
        $this->expectException(\Illuminate\Database\QueryException::class);

        //act
        Espacio::create([
            'nombre' => 'Sin Tipo',
            'aforo' => 10,
            'tipo_espacio_id' => null,
            'loc_latitud' => $loc->latitud,
            'loc_longitud' => $loc->longitud,
            'loc_piso' => $loc->piso,
            'horario_inicio' => $hor->inicio,
            'horario_fin' => $hor->fin,
        ]);
    }

    /**
     * Test para validar que el tipo solo acepta valores del enumerado
     * @test
     */
    public function T06_estado_should_throwException_when_value_is_not_in_enum()
    {
        //Arrange
        $tipo = TipoEspacio::create(['nombre' => 'Tipo B']);
        $loc = Localizacion::create(['latitud' => 3.0, 'longitud' => 3.0, 'piso' => 1]);
        $hor=Horario::create(['inicio' => '08:00:00', 'fin' => '10:00:00']);

        //Assert
        $this->expectException(\ValueError::class);

        //act
        Espacio::create([
            'nombre' => 'Estado Invalido',
            'aforo' => 10,
            'estado' => 'INVALIDO',
            'tipo_espacio_id' => $tipo->id,
            'loc_latitud' => $loc->latitud,
            'loc_longitud' => $loc->longitud,
            'loc_piso' => $loc->piso,
            'horario_inicio' => $hor->inicio,
            'horario_fin' => $hor->fin,
        ]);
    }
}
