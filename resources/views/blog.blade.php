{{-- resources/views/blog.blade.php --}}
@extends('layouts.master')
@section('title', 'Página de incidencias')
@section('content')
{{-- Cabecera --}}
<main>
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h3 mb-0 text-dark">Incidencias Reportadas</h1>
                    <p class="text-muted small mt-1 mb-0">Supervisión del estado de las instalaciones</p>
                </div>
            </div>
        </div>
    </div>

    {{-- cuadrícula de incidencias --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse ($incidencias as $incidencia)
        <div class="col">
            <div class="card h-100 shadow-sm border-light">

                {{-- ponemos la foto si hay --}}
                @if ($incidencia->foto)
                <img src="{{ asset('images/incidencias/' . $incidencia->foto) }}" alt="Foto de la incidencia" class="card-img-top object-fit-cover" style="height: 12rem;" />
                @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 8rem;">
                    <span class="text-muted small fst-italic d-flex align-items-center gap-2 px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                          <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                          <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                        </svg>
                        Sin foto adjunta
                    </span>
                </div>
                @endif

                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-primary px-3 py-2">{{ $incidencia->id}}</span>
                    </div>

                    <p class="card-text small text-secondary flex-grow-1 mb-4">
                        "{{ $incidencia->descripcion }}"
                    </p>

                    <div class="border-top pt-3 mt-auto">
                        <div class="d-flex align-items-center gap-2">
                            <span class="small fw-bold text-dark">{{ $incidencia->usuario->getFullName() ?? 'Usuario desconocido'}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-light border border-dashed text-center p-5 flex flex-grow-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-file-earmark-text text-secondary mb-3" viewBox="0 0 16 16">
                    <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                    <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v3A2.5 2.5 0 0 0 12 5.5h3v10.5a1 1 0 0 1-1 1h-8a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                </svg>
                <p class="text-muted mb-0">No hay incidencias reportadas en el sistema.</p>
            </div>
        </div>
        @endforelse
    </div>
</main>

@endsection
