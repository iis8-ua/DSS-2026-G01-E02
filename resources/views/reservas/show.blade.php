@extends('layouts.master')

@section('title', 'Detalles de la Reserva')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h1 class="h4 mb-0" style="color: #003366;">
                        <i class="bi bi-ticket-detailed me-2"></i>Detalle de Reserva #{{ $reserva->id }}
                    </h1>
                    {{-- Etiqueta de estados --}}
                    <span class="badge 
                        @if($reserva->estado->value == 'APROBADA' || $reserva->estado->value == 'ACEPTADA') bg-success 
                        @elseif($reserva->estado->value == 'RECHAZADA' || $reserva->estado->value == 'CANCELADA') bg-danger 
                        @else bg-warning text-dark @endif">
                        {{ $reserva->estado->value }}
                    </span>
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
                                {{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('d/m/Y - H:i') }}
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="text-muted mb-1">Hora de Fin</h6>
                            <p class="mb-0">
                                <i class="bi bi-calendar-check me-1"></i> 
                                {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('d/m/Y - H:i') }}
                            </p>
                        </div>
                    </div>

                    {{-- Tipo de reserva --}}
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="text-muted mb-1">Tipo de Reserva</h6>
                            <p class="mb-0">
                                @if($reserva->reservaGrupal)
                                    <span class="badge bg-info text-white"><i class="bi bi-people-fill me-1"></i> Grupal</span>
                                @else
                                    <span class="badge bg-secondary"><i class="bi bi-person-fill me-1"></i> Individual</span>
                                @endif
                            </p>
                        </div>
                        @if($reserva->reservaGrupal)
                        <div class="col-sm-6">
                            <h6 class="text-muted mb-1">Aforo Solicitado</h6>
                            <p class="mb-0">{{ $reserva->reservaGrupal->aforo_max }} personas</p>
                        </div>
                        @endif
                    </div>

                    {{-- Botones para editar la reserva o volver atrás --}}
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('reservas.index') }}" class="btn btn-light border">
                            <i class="bi bi-arrow-left me-1"></i> Volver al listado
                        </a>
                        <a href="{{ route('reservas.edit', $reserva->id) }}" class="btn text-white" style="background-color: #003366;">
                            <i class="bi bi-pencil me-1"></i> Editar Reserva
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection