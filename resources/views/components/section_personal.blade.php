<div class="card shadow-sm border-0 border-top border-success border-4 mb-4 bg-light">
    <div class="card-body p-4">
        <h4 class="card-title text-success"><i class="bi bi-nintendo-switch"></i> Panel de Gestión</h4>

        <div class="d-flex flex-wrap gap-3 mb-4">
            <a href="{{ route('gestor.reservas.pendientes') }}" class="btn btn-success btn-lg px-4 shadow-sm">
                <i class="bi bi-check2-square me-1"></i> Gestionar Reservas
            </a>
            <a href="{{ route('incidencias.index') }}" class="btn btn-danger btn-lg px-4 shadow-sm">
                <i class="bi bi-exclamation-triangle me-1"></i> Revisar Incidencias
            </a>
            <a href="{{ route('espacios.catalogo') }}" class="btn btn-outline-secondary btn-lg px-4 shadow-sm">
                <i class="bi bi-building me-1"></i> Ver Catálogo
            </a>
        </div>
    </div>
</div>