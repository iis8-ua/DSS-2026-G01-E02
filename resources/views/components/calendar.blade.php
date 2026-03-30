@props([
    'horariosDisponibles' => collect(),
    'reservasExistentes' => collect(),
])

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h2 class="h5 mb-4 fw-bold">Disponibilidad del espacio</h2>

        <div class="mb-4">
            <h3 class="h6 fw-semibold">Horarios permitidos</h3>

            @if($horariosDisponibles->isEmpty())
                <p class="text-muted mb-0">Este espacio no tiene horarios configurados.</p>
            @else
                <div class="list-group">
                    @foreach($horariosDisponibles as $horario)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Disponible</span>
                            <span class="fw-semibold">
                                {{ $horario->inicio->format('H:i') }} - {{ $horario->fin->format('H:i') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-3">
            <h3 class="h6 fw-semibold">Reservas ya registradas</h3>

            @if($reservasExistentes->isEmpty())
                <p class="text-success mb-0">Todavía no hay reservas para este espacio.</p>
            @else
                <div class="list-group">
                    @foreach($reservasExistentes as $reserva)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">
                                    {{ $reserva->hora_inicio->format('d/m/Y') }}
                                </div>
                                <small class="text-muted">
                                    Estado: {{ $reserva->estado->value }}
                                </small>
                            </div>
                            <span class="fw-semibold">
                                {{ $reserva->hora_inicio->format('H:i') }} - {{ $reserva->hora_fin->format('H:i') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mt-4">
            <span class="badge text-bg-success me-2">Horario permitido</span>
            <span class="badge text-bg-secondary">Reserva existente</span>
        </div>
    </div>
</div>