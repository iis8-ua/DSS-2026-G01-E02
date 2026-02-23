<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Representa una notificación a un usuario.
 * 
 * Puede estar asociada opcionalmente a una incidencia.
 */
class Notificacion extends Model
{
    use HasUuids;

    protected $table = 'notificaciones';
    protected $primaryKey = 'id';
    protected $timestamps = false;

    protected $fillable = [
        'id',
        'texto',
        'vista',
        'incidencia',
        'usuario'
    ];

    protected function incidencias(){
        return $this->belongsTo(Incidencia::class);
    }

    protected function hasIncidencia(){
        return $this->incidencia !== null;
    }

}

