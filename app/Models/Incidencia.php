<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Representa una incidencia que envía un usuario al sistema
 */
class Incidencia extends Model
{
    // UUID de la incidencia
    public $id = null; 
    // Descripción dada por el usuario
    public $descripcion = "";
    // Foto (opcional) asociada
    public $foto = null;
    // Usuario autor de la incidencia
    public $autor = null;

    public function __construct($autor, $descripcion, $foto){
        $this->autor = $autor;
        $this->descripcion = $descripcion;
        $this->foto = $foto;
    }

}
