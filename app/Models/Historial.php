<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Historial extends Model{
    use HasFactory, HasUuids;

    protected $table = 'historiales';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'user_id', 'user_id');
    }

    public function addReserva(Reserva $reserva): void
    {
        $reserva->user_id = $this->user_id;
        $reserva->save();
    }

    public function deleteReserva(Reserva $reserva): void
    {
        if ($reserva->user_id === $this->user_id) {
            $reserva->delete();
        }
    }

    public function clearReservas(): void
    {
        $this->reservas()->delete();
    }
}
