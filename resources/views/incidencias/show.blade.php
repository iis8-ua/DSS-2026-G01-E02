@extends('layouts.master')
@section('title', 'Detalles de la Incidencia')
@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h1 class="h4 mb-0" style="color: #003366;">
                        Detalle de Incidencia #{{ $incidencia->id }}
                    </h1>
                </div>
                <div class="card-body p-4">

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <h6 class="text-muted mb-1">Reportado por</h6>
                            <p class="fw-bold mb-0">
                                <i class="bi bi-person me-1"></i>
                                {{ $incidencia->usuario->name ?? 'Usuario Desconocido' }}
                            </p>
                        </div>
                    </div>

                    {{-- Descripción --}}
                    <div class="mb-4 bg-light p-3 rounded">
                        <h6 class="text-muted mb-1">Descripción</h6>
                        <p class="mb-0">
                            <i class="bi bi-card-text me-1"></i>
                            {{ $incidencia->descripcion }}
                        </p>
                    </div>

                    @if($incidencia->foto)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Fotografía adjunta</h6>
                        <img src="{{ asset('images/incidencias/' . $incidencia->foto) }}"
                             alt="Foto de la incidencia"
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 350px; object-fit: cover;">
                    </div>
                    @endif

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('incidencias.index') }}" class="btn btn-light border">
                            Volver al listado
                        </a>
                        @if(Auth::user()->tipo_usuario == "ADMIN")
                            <a href="{{ route('incidencias.edit', $incidencia->id) }}" class="btn text-white" style="background-color: #003366;">
                                Editar Incidencia
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
