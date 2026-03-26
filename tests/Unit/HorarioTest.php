<?php

namespace Tests\Unit;

use App\Enums\EstadoEspacio;
use App\Enums\EstadoReserva;
use App\Models\Espacio;
use App\Models\Horario;
use App\Models\Localizacion;
use App\Models\Reserva;
use App\Models\TipoEspacio;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class HorarioTest extends TestCase
{
    use RefreshDatabase;

    /***
     * Test de creacion
     * @test
     */
    public function T01_create_should_persist_times_and_generate_uuid(){
        //arrange y act
        $horario = Horario::create([
            'inicio' => '08:00:00',
            'fin'    => '10:00:00'
        ]);
        // Assert
        $this->assertNotNull($horario->id);
        $this->assertEquals('08:00:00', $horario->inicio);
        $this->assertEquals('10:00:00', $horario->fin);
    }

    /**
     * Test de la colision
     * @test
     */
    public function T02_colisiona_should_detect_overlapping_times(){
        //arrange
        $h1 = new Horario(['inicio' => '08:00:00', 'fin' => '10:00:00']);
        $h2 = new Horario(['inicio' => '09:00:00', 'fin' => '11:00:00']);
        $h3 = new Horario(['inicio' => '11:00:00', 'fin' => '12:00:00']);

        //act y assert
        $this->assertTrue($h1->colisiona($h2), "Debería colisionar: 09:00 está entre 08:00 y 10:00");
        $this->assertFalse($h1->colisiona($h3), "No debería colisionar: empiezan cuando el otro termina");
    }

    /**
     * Test de integridad
     * @test
     */
    public function T03_start_time_should_be_before_end_time()
    {
        //arrange
        $h = new Horario([
            'inicio' => '10:00:00',
            'fin'    => '12:00:00'
        ]);

        //act y assert
        $this->assertTrue($h->inicio->lt($h->fin), "La hora de inicio debe ser anterior a la de fin");
    }
}
