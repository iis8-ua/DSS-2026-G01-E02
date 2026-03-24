<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Localizacion extends Model{
    use HasUuids;

    protected $table = 'localizacions';
    public $timestamps = false;

    protected $fillable = ['latitud', 'longitud', 'piso'];
}
