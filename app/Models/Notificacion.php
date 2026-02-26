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
    public $timestamps = false;

    protected $fillable = [
        'id',
        'texto',
        'vista',
        'incidencia_id',
    ];

    public function incidencia(){
        return $this->belongsTo(Incidencia::class,'incidencia_id','id');
    }

    public function hasIncidencia(){
        return $this->incidencia !== null;
    }

}

