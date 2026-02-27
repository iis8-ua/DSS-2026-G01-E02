<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    public $incrementing = false;
    protected $keyType = 'array';

    protected $fillable = [
        'inicio',
        'fin',
    ];

    protected $casts = [
        'inicio' => 'datetime',
        'fin' => 'datetime',
    ];

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('inicio', '=', $this->getAttribute('inicio'))
            ->where('fin', '=', $this->getAttribute('fin'));

        return $query;
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'fecha_inicio', 'inicio');
    }


    public function colisiona(Horario $otro): bool
    {
        return $this->inicio->lt($otro->fin) &&
               $otro->inicio->lt($this->fin);
    }
}
