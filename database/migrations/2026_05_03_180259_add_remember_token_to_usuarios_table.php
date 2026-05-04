<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Añade la columna remember_token
            $table->rememberToken()->after('password');
        });
    }

    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Permite dar marcha atrás si nos arrepentimos
            $table->dropRememberToken();
        });
    }
};