<?php

namespace Tests\Feature;

use App\Models\TipoEspacio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Localizacion;
use App\Models\Espacio;

class LocalizacionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test para la relacion con el espacio
     * @test
     */
    public function T01_espacio_should_return_Espacio_when_localizacion_has_espacio_assigned()
    {
        //Arrange
        $localizacion = Localizacion::create([
            'latitud' => 40.5,
            'longitud' => -3.5,
            'piso' => 2,
        ]);

        $tipo = TipoEspacio::create(['nombre' => 'Aula']);

        $espacio = Espacio::create([
            'nombre' => 'Aula 1',
            'aforo' => 30,
            'tipo_espacio_id' => $tipo->id,
            'loc_latitud' => $localizacion->latitud,
            'loc_longitud' => $localizacion->longitud,
            'loc_piso' => $localizacion->piso,
            'horario_inicio' => '2026-02-27 08:00:00',
            'horario_fin' => '2026-02-27 10:00:00',
        ]);

        //Act
        $resultado=$localizacion->espacio;

        //Assert
        $this->assertInstanceOf(Espacio::class, $resultado);
        $this->assertEquals($espacio->id, $resultado->id);
    }

    /**
     * Test para ver el funcionamiento de la clave primaria porque es compuesta
     * @test
     */
    public function T02_create_should_throwException_when_primaryKey_is_duplicated()
    {
        //Arrange
        Localizacion::create([
            'latitud' => 10.5,
            'longitud' => -1.2,
            'piso' => 1,
        ]);

        //Assert
        $this->expectException(\Illuminate\Database\QueryException::class);

        //act
        Localizacion::create([
            'latitud' => 10.5,
            'longitud' => -1.2,
            'piso' => 1,
        ]);

    }

    /**
     * Test para ver que puede no tener espacio
     * @test
     */
    public function T03_espacio_should_return_Null_when_localizacion_has_no_espacio()
    {
        //Arrange
        $localizacion = Localizacion::create([
            'latitud' => 40.5,
            'longitud' => -3.5,
            'piso' => 2,
        ]);

        //act
        $resultado = $localizacion->espacio;

        //Assert
        $this->assertNull($resultado);
    }

    /**
     * Test para ver los updates de la clave primaria
     * @test
     */
    public function T04_update_should_modify_Record_when_localizacion_keys_are_valid()
    {
        //Arrange
        $localizacion = Localizacion::create([
            'latitud' => 10.0,
            'longitud' => 20.0,
            'piso' => 1,
        ]);

        //Act
        Localizacion::where('latitud', 10.0)
            ->where('longitud', 20.0)
            ->where('piso', 1)
            ->update(['piso' => 5]);

        //Assert
        $localizacionActualizada = Localizacion::where('latitud', 10)
            ->where('longitud', 20)
            ->where('piso', 5)
            ->first();

        $this->assertEquals(5, $localizacionActualizada->piso);
    }

}
