<?php

namespace Tests\Unit;

use App\Models\Espacio;
use App\Models\Horario;
use App\Models\Localizacion;
use App\Models\TipoEspacio;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
        $tipo = TipoEspacio::create(['nombre' => 'Laboratorio']);
        $loc = Localizacion::create(['latitud' => 10.0, 'longitud' => 10.0, 'piso' => 1]);

        $espacio = Espacio::create([
            'nombre'          => 'Lab Química',
            'aforo'           => 20,
            'estado'          => 'HABILITADO',
            'tipo_espacio_id' => $tipo->id,
            'localizacion_id' => $loc->id,
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
        $loc = Localizacion::create(['latitud' => 40.5, 'longitud' => -3.5, 'piso' => 2]);
        $tipo = TipoEspacio::create(['nombre' => 'Aula']);

        $espacio = Espacio::create([
            'nombre'          => 'Aula Magna',
            'aforo'           => 50,
            'estado'          => 'HABILITADO',
            'tipo_espacio_id' => $tipo->id,
            'localizacion_id' => $loc->id,
        ]);

        //Act
        $resultado=$espacio->localizacion;

        //Assert
        $this->assertInstanceOf(Localizacion::class, $resultado);
        $this->assertEquals($loc->id, $resultado->id);
    }

    /**
     * Test de la relacion con Horario
     * @test
     */
    public function T03_horario_should_return_Horario_when_espacio_has_horario_dates(){
        //Arrange
        $tipo = TipoEspacio::create(['nombre' => 'Despacho']);
        $loc = Localizacion::create(['latitud' => 5.0, 'longitud' => 5.0, 'piso' => 0]);
        $hor = Horario::create(['inicio' => '09:00:00', 'fin' => '14:00:00']);

        $espacio = Espacio::create([
            'nombre'          => 'Despacho 1',
            'aforo'           => 2,
            'estado'          => 'HABILITADO',
            'tipo_espacio_id' => $tipo->id,
            'localizacion_id' => $loc->id,
        ]);

        $espacio->horario()->attach($hor->id);

        //Act
        $resultado=$espacio->horario;

        //Assert
        $this->assertInstanceOf(Collection::class, $resultado);
        $this->assertTrue($resultado->contains($hor));
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

        Espacio::create([
            'nombre'          => 'Espacio 1',
            'aforo'           => 10,
            'estado'          => 'HABILITADO',
            'tipo_espacio_id' => $tipo->id,
            'localizacion_id' => $loc->id,
        ]);

        //Assert
        $this->expectException(QueryException::class);

        //act
        Espacio::create([
            'nombre'          => 'Espacio 2',
            'aforo'           => 10,
            'estado'          => 'HABILITADO',
            'tipo_espacio_id' => $tipo->id,
            'localizacion_id' => $loc->id,
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

        //Assert
        $this->expectException(\Illuminate\Database\QueryException::class);

        //act
        Espacio::create([
            'nombre'          => 'Sin Tipo',
            'aforo'           => 10,
            'estado'          => 'HABILITADO',
            'tipo_espacio_id' => null,
            'localizacion_id' => $loc->id,
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

        //Assert
        $this->expectException(\ValueError::class);

        //act
        Espacio::create([
            'nombre'          => 'Estado Invalido',
            'aforo'           => 10,
            'estado'          => 'ESTADO_INVENTADO',
            'tipo_espacio_id' => $tipo->id,
            'localizacion_id' => $loc->id,
        ]);
    }
}
