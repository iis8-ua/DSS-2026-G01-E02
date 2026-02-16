<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Representa una incidencia que envía un usuario al sistema
 */
class Incidencia extends Model
{
    // UUID de la incidencia
    private $id = null; 
    // Descripción dada por el usuario
    private $descripcion = "";
    // Foto (opcional) asociada
    private $foto = null;
    // Usuario autor de la incidencia
    private $autor = null;

    public function __construct($autor, $descripcion, $foto){
        $this->autor = $autor;
        $this->descripcion = $descripcion;
        $this->foto = $foto;
    }

    public function getID(){
        return $this->id;
    }

    public function getDescripcion(): string{
        return $this->descripcion;
    }

    public function getfoto(){
        return $this->foto;
    }

    public function getAutor(): Usuario{
        return $this->autor;
    }

}
