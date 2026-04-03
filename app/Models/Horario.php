<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasUuids;

    protected $table = 'horarios';
    public $timestamps = false;

    protected $fillable = [
        'inicio',
        'fin',
    ];

    protected $casts = [
        'inicio' => 'datetime',
        'fin' => 'datetime',
    ];

    public function colisiona(Horario $otro): bool
    {
        return $this->inicio->lt($otro->fin) &&
               $otro->inicio->lt($this->fin);
    }
}
