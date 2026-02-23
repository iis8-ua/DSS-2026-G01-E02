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
        $tipo=TipoEspacio::factory()->create();
        $espacio=Espacio::factory()->create(['tipo_espacio_id' => $tipo->id]);

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
        $localizacion=Localizacion::factory()->create([
            'latitud' => 40.5,
            'longitud' => -3.5,
            'piso' =>2,
        ]);

        $espacio=Espacio::factory()->create([
            'loc_latitud' => $localizacion->latitud,
            'loc_longitud' => $localizacion->longitud,
            'loc_piso' => $localizacion->piso,
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
        $horario = Horario::factory()->create([
            'inicio' => '2024-09-01 08:00:00', 'fin' => '2024-06-30 15:00:00',
        ]);
        $espacio = Espacio::factory()->create([
            'horario_inicio' => $horario->inicio, 'horario_fin' => $horario->fin,
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
        $localizacion = Localizacion::factory()->create();

        Espacio::factory()->create([
            'loc_latitud' => $localizacion->latitud,
            'loc_longitud' => $localizacion->longitud,
            'loc_piso' => $localizacion->piso,
        ]);

        //Assert
        $this->expectException(\Illuminate\Database\QueryException::class);

        //act
        Espacio::factory()->create([
            'loc_latitud' => $localizacion->latitud,
            'loc_longitud' => $localizacion->longitud,
            'loc_piso' => $localizacion->piso,
        ]);
    }

    /**
     * Test que prueba que el tipo de espacio no es nulo
     * @test
     */
    public function T05_crear_should_throwException_when_tipoEspacio_is_null()
    {
        //Assert
        $this->expectException(\Illuminate\Database\QueryException::class);

        //act
        Espacio::factory()->create(['tipo_espacio_id' => null,]);
    }

    /**
     * Test para validar que el tipo solo acepta valores del enumerado
     * @test
     */
    public function T06_estado_should_throwException_when_value_is_not_in_enum()
    {
        //Assert
        $this->expectException(\ValueError::class);

        //act
        Espacio::factory()->create(['estado' => 'INVALIDO',]);
    }
}
