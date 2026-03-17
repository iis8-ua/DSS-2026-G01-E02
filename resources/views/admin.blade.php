@extends('layouts.master')

@section('title', 'Panel de Administración')

@section('content')
<div class="container my-5 flex-grow-1">

    <div class="d-flex align-items-center mb-4 gap-3">
        <div>
            <h1 class="h3 mb-0" style="color: #003366;">Panel de Administración</h1>
        </div>
    </div>

    {{-- para acceder al crud de cada modulo que hemos hecho--}}
    <div class="row g-4 mb-5">
        {{-- espacios--}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-primary hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0 fw-bold">ESPACIOS</h5>
                    </div>
                    <h2 class="display-5 fw-bold text-dark mb-1">{{ $totalEspacios }}</h2>
                    <br>
                    <a href="{{ route('espacios.index') }}" class="btn btn-primary w-100" style="background-color: #003366; border-color: #003366;">Gestionar Espacios</a>
                </div>
            </div>
        </div>

        {{-- tipo de espacio --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-success hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0 fw-bold">TIPOS DE ESPACIO</h5>
                    </div>
                    <h2 class="display-5 fw-bold text-dark mb-1">{{ $totalTipos }}</h2>
                    <br>
                    <a href="{{ route('tipos-espacio.index') }}" class="btn btn-outline-success w-100">Gestionar Tipos</a>
                </div>
            </div>
        </div>

        {{-- Localizaciones --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-warning hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0 fw-bold">LOCALIZACIONES</h5>
                    </div>
                    <h2 class="display-5 fw-bold text-dark mb-1">{{ $totalLocalizaciones }}</h2>
                    <br>
                    <a href="{{ route('localizaciones.index') }}" class="btn btn-outline-warning w-100">Gestionar Localizaciones</a>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">
        {{-- para las reservas pendientes --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">Reservas Pendientes</h5>
                    <span class="badge bg-secondary">{{ $totalReservas }} Reservas en total</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th>Alumno</th>
                                <th>Espacio</th>
                                <th>Fecha Solicitud</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($ultimasReservas as $reserva)
                            <tr>
                                <td class="fw-bold">{{ $reserva->alumno->getFullName() ?? 'Usuario' }}</td>
                                <td>{{ $reserva->espacio->nombre ?? 'N/A' }}</td>
                                <td>{{ $reserva->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-outline-dark">Ver detalle</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No hay reservas pendientes de revisión.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- parte de la gestion de los usuarios, separada de las demas clases --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100 border-start border-4 border-info bg-light">
                <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                    <h5 class="fw-bold text-dark">Gestión de Usuarios</h5>
                    <p class="text-muted mb-4">Actualmente hay <strong>{{ $totalUsuarios }}</strong> usuarios registrados en el sistema.</p>
                    <button class="btn btn-info text-white w-100" disabled>Módulo en desarrollo</button>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .transition {
        transition: all .3s ease;
    }
</style>
@endsection
