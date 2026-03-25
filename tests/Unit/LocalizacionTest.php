<?php

namespace Tests\Unit;

use App\Models\Espacio;
use App\Models\Horario;
use App\Models\Localizacion;
use App\Models\TipoEspacio;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalizacionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test para la relacion con el espacio
     * @test
     */
    public function T01_espacio_should_return_Espacio_when_localizacion_has_espacio_assigned()
    {
        //Arrange y act
        $loc = Localizacion::create([
            'latitud' => 40.5,
            'longitud' => -3.5,
            'piso' => 2,
        ]);

        //Assert
        $this->assertNotNull($loc->id);
        $this->assertEquals(40.5, $loc->latitud);
        $this->assertEquals(2, $loc->piso);
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
        $this->expectException(QueryException::class);

        //act
        Localizacion::create([
            'latitud' => 10.5,
            'longitud' => -1.2,
            'piso' => 1,
        ]);
    }



    /**
     * Test para ver los updates de la clave primaria
     * @test
     */
    public function T03_update_should_modify_Record_when_localizacion_keys_are_valid()
    {
        //Arrange
        $loc = Localizacion::create([
            'latitud' => 10.0,
            'longitud' => 20.0,
            'piso' => 1,
        ]);

        //Act
        $loc->update(['piso' => 5]);

        //Assert
        $this->assertEquals(5, $loc->fresh()->piso);
    }

}
