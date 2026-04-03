@extends('layouts.master')
@section('title', 'Detalles de la Reserva Grupal')
@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h1 class="h4 mb-0" style="color: #003366;">
                        Reserva Grupal #{{ substr($reservasGrupal->reserva_id, 0, 8) }}...
                    </h1>
                    @php
                    $ocupacion = $reservasGrupal->alumnos->count();
                    $max = $reservasGrupal->aforo_max;
                    $colorBadge = match(true) {
                    $ocupacion >= $max              => 'bg-danger',
                    $max > 0 && $ocupacion >= $max * 0.75 => 'bg-warning text-dark',
                    default                         => 'bg-success',
                    };
                    @endphp
                    <span class="badge {{ $colorBadge }}">{{ $ocupacion }}/{{ $max }} plazas</span>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <h6 class="text-muted mb-1">Alumno titular</h6>
                            <p class="fw-bold mb-0">
                                <i class="bi bi-person me-1"></i>
                                {{ $reservasGrupal->reserva->alumno->getFullName() ?? 'Usuario Desconocido' }}
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="text-muted mb-1">Espacio Reservado</h6>
                            <p class="fw-bold mb-0">
                                <i class="bi bi-geo-alt me-1"></i>
                                {{ $reservasGrupal->reserva->espacio->nombre ?? 'Espacio Eliminado' }}
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4 bg-light p-3 rounded">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <h6 class="text-muted mb-1">Hora de Inicio</h6>
                            <p class="mb-0">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $reservasGrupal->reserva->hora_inicio->format('d/m/Y - H:i') }}
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="text-muted mb-1">Hora de Fin</h6>
                            <p class="mb-0">
                                <i class="bi bi-calendar-check me-1"></i>
                                {{ $reservasGrupal->reserva->hora_fin->format('d/m/Y - H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="text-muted mb-1">Aforo máximo</h6>
                            <p class="fw-bold mb-0">
                                <i class="bi bi-people me-1"></i>
                                {{ $reservasGrupal->aforo_max }} participantes
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="text-muted mb-1">Estado de la reserva base</h6>
                            @php
                            $estadoValor = $reservasGrupal->reserva->estado->value;
                            $colorEstado = match($estadoValor) {
                            'ACEPTADA'              => 'bg-success',
                            'RECHAZADA', 'CANCELADA'=> 'bg-danger',
                            'PENDIENTE'             => 'bg-warning text-dark',
                            default                 => 'bg-secondary',
                            };
                            @endphp
                            <span class="badge {{ $colorEstado }}">{{ $estadoValor }}</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Miembros del grupo</h6>
                        @if($reservasGrupal->alumnos->count() > 0)
                        <div class="border rounded p-3 bg-light">
                            <div class="row g-2">
                                @foreach($reservasGrupal->alumnos as $alumno)
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-person-circle text-primary"></i>
                                        <div>
                                            <p class="mb-0 fw-bold small">{{ $alumno->getFullName() }}</p>
                                            <p class="mb-0 text-muted" style="font-size: 0.78rem;">{{ $alumno->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <p class="text-muted fst-italic">Sin miembros asignados al grupo.</p>
                        @endif
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('reservas-grupales.index') }}" class="btn btn-light border">
                            Volver al listado
                        </a>
                        <a href="{{ route('reservas-grupales.edit', $reservasGrupal) }}" class="btn text-white" style="background-color: #003366;">
                            Editar Reserva Grupal
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
