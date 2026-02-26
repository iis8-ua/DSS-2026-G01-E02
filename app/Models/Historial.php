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

    public function user(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'historial_id');
    }

    public function addReserva(Reserva $reserva): void
    {
        $reserva->historial_id = $this->id;
        $reserva->save();
    }

    public function deleteReserva(Reserva $reserva): void
    {
        if ($reserva->historial_id === $this->id) {
            $reserva->historial_id = null;
            $reserva->save();
        }
    }

    public function clearReservas(): void
    {
        $this->reservas()->update(['historial_id' => null]);
    }
}