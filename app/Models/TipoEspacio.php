<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TipoEspacio extends Model
{
    use HasUuids; //esto lo que hace es activar la generacion auto de los uuid

    //se pone para que se eviten errores, luego se ve si se puede suprimir
    protected $table = 'tipo_espacios';
    public $timestamps = false;

    //esta variable fillable es la que nos da los campos a rellenar
    protected $fillable = ['nombre'];

}
