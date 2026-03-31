@extends('layouts.master')
@section('title', 'Detalle de Notificación')
@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h1 class="h4 mb-0" style="color: #003366;">
                        Detalle de Notificación #{{ $notificacion->id }}
                    </h1>
                    <span class="badge {{ $notificacion->vista ? 'bg-secondary' : 'bg-primary' }}">
                        {{ $notificacion->vista ? 'Leída' : 'No leída' }}
                    </span>
                </div>
                <div class="card-body p-4">

                    {{-- Destinatario --}}
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <h6 class="text-muted mb-1">Destinatario</h6>
                            <p class="fw-bold mb-0">
                                <i class="bi bi-person me-1"></i>
                                {{ $notificacion->usuario->name ?? 'Usuario Desconocido' }}
                            </p>
                        </div>
                    </div>

                    {{-- Título --}}
                    <div class="mb-4 bg-light p-3 rounded">
                        <h6 class="text-muted mb-1">Título</h6>
                        <p class="mb-0 fw-bold">
                            <i class="bi bi-bell me-1"></i>
                            {{ $notificacion->titulo }}
                        </p>
                    </div>

                    {{-- Texto --}}
                    <div class="mb-4 bg-light p-3 rounded">
                        <h6 class="text-muted mb-1">Mensaje</h6>
                        <p class="mb-0">
                            <i class="bi bi-card-text me-1"></i>
                            {{ $notificacion->texto }}
                        </p>
                    </div>

                    {{-- Incidencia asociada --}}
                    @if($notificacion->hasIncidencia())
                    <div class="mb-4 bg-light p-3 rounded">
                        <h6 class="text-muted mb-1">Incidencia Asociada</h6>
                        <p class="mb-0">
                            <i class="bi bi-exclamation-triangle me-1 text-warning"></i>
                            <a href="{{ route('incidencias.show', $notificacion->incidencia->id) }}">
                                Incidencia #{{ $notificacion->incidencia->id }}
                            </a>
                        </p>
                    </div>
                    @endif

                    {{-- Imagen --}}
                    @if($notificacion->imagen)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Imagen adjunta</h6>
                        <img src="{{ asset('images/notificaciones/' . $notificacion->imagen) }}"
                             alt="Imagen de la notificación"
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 350px; object-fit: cover;">
                    </div>
                    @endif

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('notificaciones.index') }}" class="btn btn-light border">
                            Volver al listado
                        </a>
                        <a href="{{ route('notificaciones.edit', $notificacion->id) }}" class="btn text-white" style="background-color: #003366;">
                            Editar Notificación
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
