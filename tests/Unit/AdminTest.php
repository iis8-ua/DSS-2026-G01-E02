<?php

namespace Tests\Unit;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test para ver el tipo correcto
     * @test
     */
    public function T01_admin_creating_should_assign_correct_tipo_usuario()
    {
        //arrange y act
        $admin = Admin::create([
            'name' => 'Admin',
            'apellidos' => 'Admin2',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'dni' => '12345678A'
        ]);

        //assert
        $this->assertEquals(Admin::class, $admin->tipo_usuario);
        $this->assertCount(1, Admin::all());
    }

}
