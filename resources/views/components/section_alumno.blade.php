{{-- el borde que separa las cajas de informacion --}}
<div class="card shadow-sm border-0 border-top border-primary border-4 mb-4 bg-light">
    <div class="card-body p-4">
        <h4 class="card-title text-primary"><i class="bi bi-building-fill-add"></i> Centro de Reservas </h4>
        <p class="card-text text-muted mb-4">Desde aquí puedes consultar la disponibilidad de los espacios de la universidad y gestionar tus reservas.</p>

        <div class="d-flex gap-3 mb-5">
            <a href="{{ route('espacios.catalogo') }}" class="btn btn-primary btn-lg px-4 shadow-sm">
                <i class="bi bi-calendar-plus me-1"></i> Nueva Reserva
            </a>
            <a href="#" class="btn btn-outline-primary btn-lg px-4 shadow-sm">
                <i class="bi bi-clock-history me-1"></i> Historial Completo
            </a>
        </div>

        <h5 class="border-bottom pb-2 mb-3 text-dark">Mis Próximas Reservas</h5>
        
        <div class="alert alert-white border text-center text-muted p-5 shadow-sm bg-white">
            <i class="bi bi-calendar-x fs-1 text-secondary mb-3 d-block"></i>
            <h6 class="fw-bold">No tienes reservas activas en este momento.</h6>
            <p class="mb-0">Ve al catálogo de espacios para realizar tu primera reserva.</p>
        </div>
    </div>
</div>