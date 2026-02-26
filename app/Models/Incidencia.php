<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Representa una incidencia que envía un usuario al sistema
 */
class Incidencia extends Model
{
    use HasUuids;
    protected $table = 'incidencias';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'descripcion',
        'foto'
    ];


}
