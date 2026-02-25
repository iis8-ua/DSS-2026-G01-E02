<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Horario extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'horarios';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'inicio',
        'fin',
    ];

    protected $casts = [
        'inicio' => 'datetime',
        'fin' => 'datetime',
    ];

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'horario_id');
    }


    public function colisiona(Horario $otro): bool
    {
        return $this->inicio->lt($otro->fin) &&
               $otro->inicio->lt($this->fin);
    }
}