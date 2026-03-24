@extends('layouts.master')

@section('title', 'Detalles de la Reserva')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h1 class="h4 mb-0" style="color: #003366;">
                        Detalle de Reserva #{{ $reserva->id }}
                    </h1>
                    {{-- Etiqueta de estado --}}
                    @php
                        $estadoValor = $reserva->estado->value;
                        $colorBadge = match($estadoValor) {
                        'ACEPTADA'  => 'bg-success',
                        'RECHAZADA', 'CANCELADA' => 'bg-danger',
                        'PENDIENTE' => 'bg-warning text-dark',
                        default     => 'bg-secondary',
                    };
                    @endphp
                    <span class="badge {{ $colorBadge }}">{{ $estadoValor }}</span>
                </div>

                <div class="card-body p-4">
                    <div class="row mb-4">
                        {{-- Solicitante --}}
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <h6 class="text-muted mb-1">Solicitante</h6>
                            <p class="fw-bold mb-0">
                                <i class="bi bi-person me-1"></i>
                                {{ $reserva->alumno->getFullName() ?? 'Usuario Desconocido' }}
                            </p>
                        </div>
                        {{-- Espacio --}}
                        <div class="col-sm-6">
                            <h6 class="text-muted mb-1">Espacio Reservado</h6>
                            <p class="fw-bold mb-0">
                                <i class="bi bi-geo-alt me-1"></i>
                                {{ $reserva->espacio->nombre ?? 'Espacio Eliminado' }}
                            </p>
                        </div>
                    </div>

                    {{-- Fechas --}}
                    <div class="row mb-4 bg-light p-3 rounded">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <h6 class="text-muted mb-1">Hora de Inicio</h6>
                            <p class="mb-0">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $reserva->hora_inicio->format('d/m/Y - H:i') }}
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="text-muted mb-1">Hora de Fin</h6>
                            <p class="mb-0">
                                <i class="bi bi-calendar-check me-1"></i>
                                {{ $reserva->hora_fin->format('d/m/Y - H:i') }}
                            </p>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('reservas.index') }}" class="btn btn-light border">
                             Volver al listado
                        </a>
                        <a href="{{ route('reservas.edit', $reserva->id) }}" class="btn text-white" style="background-color: #003366;">
                            Editar Reserva
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
