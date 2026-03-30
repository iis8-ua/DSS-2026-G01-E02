<div class="card shadow-sm border-0 border-top border-primary border-4 mb-4 bg-light">
    <div class="card-body p-4">
        <h4 class="card-title text-primary"><i class="bi bi-building-fill-add"></i> Centro de Reservas </h4>
        <p class="card-text text-muted mb-4">
            Desde aquí puedes consultar la disponibilidad de los espacios de la universidad y gestionar tus reservas.
        </p>

        <div class="d-flex gap-3 mb-5">
            <a href="{{ route('espacios.catalogo') }}" class="btn btn-primary btn-lg px-4 shadow-sm">
                <i class="bi bi-calendar-plus me-1"></i> Nueva Reserva
            </a>

            <a href="{{ route('reservas.mias') }}" class="btn btn-outline-primary btn-lg px-4 shadow-sm">
                <i class="bi bi-journal-text me-1"></i> Mis Reservas
            </a>
        </div>

        <h5 class="border-bottom pb-2 mb-3 text-dark">Mis Próximas Reservas</h5>

        @php
            $reservasActivas = ($reservas ?? collect())->filter(function ($reserva) {
                return $reserva->hora_fin >= now();
            });
        @endphp

        @forelse($reservasActivas as $reserva)
            <div class="card mb-3 border-0 shadow-sm bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $reserva->espacio->nombre ?? 'Espacio sin nombre' }}</h6>
                            <p class="text-muted mb-1">
                                {{ $reserva->hora_inicio->format('d/m/Y H:i') }}
                                -
                                {{ $reserva->hora_fin->format('H:i') }}
                            </p>
                            <small class="text-muted">
                                Estado: {{ $reserva->estado->value }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-white border text-center text-muted p-5 shadow-sm bg-white">
                <i class="bi bi-calendar-x fs-1 text-secondary mb-3 d-block"></i>
                <h6 class="fw-bold">No tienes reservas activas en este momento.</h6>
                <p class="mb-0">Ve al catálogo de espacios para realizar tu primera reserva.</p>
            </div>
        @endforelse
    </div>
</div>