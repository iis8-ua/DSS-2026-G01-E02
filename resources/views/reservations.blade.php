@extends('layouts.master')

@section('title', 'Cátalogo de Espacios - EspaciUA')

@section('css')
<style>
    .text-ua-gold { color: #b8860b; }
    .text-ua-blue { color: #003366; }

    .card-espacio {
        border: none;
        transition: transform 0.2s;
    }
    .card-espacio:hover {
        transform: scale(1.02);
    }
    .btn-header-espacio {
        background-color: #005bb5;
        color: white;
        font-weight: bold;
        border-radius: 8px 8px 0 0;
        padding: 12px;
        text-transform: uppercase;
        width: 100%;
        display: block;
        text-align: center;
        text-decoration: none;
    }
    .btn-header-espacio:hover {
        background-color: #003366;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container mb-5">

    <div class="text-center mb-5 mt-3">
        <h2 class="fw-bold text-secondary text-uppercase mb-3">Selecciona tu opción</h2>
        <h1 class="fw-bold text-ua-gold text-uppercase">Reservar Instalaciones</h1>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

        @forelse($espacios as $espacio)
        <div class="col">
            <div class="card card-espacio h-100 shadow-sm">

                <a href="#" class="btn-header-espacio">
                    {{ $espacio->nombre }}
                </a>

                @if($espacio->imagen)
                <img src="{{ asset('images/espacios/' . $espacio->imagen) }}"
                     class="card-img-top rounded-0"
                     alt="{{ $espacio->nombre }}"
                     style="height: 220px; object-fit: cover;">
                @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($espacio->nombre) }}&background=e9ecef&color=003366&size=400&font-size=0.3"
                     class="card-img-top rounded-0"
                     alt="{{ $espacio->nombre }}"
                     style="height: 220px; object-fit: cover;">
                @endif

                <div class="card-body bg-light">
                    <p class="card-text mb-1">
                        <i class="bi bi-people-fill text-ua-blue"></i> <strong>Aforo:</strong> {{ $espacio->aforo }} personas
                    </p>
                    <p class="card-text mb-1">
                        <i class="bi bi-info-circle-fill text-ua-blue"></i> <strong>Detalles:</strong> {{ $espacio->caracteristicas ?? 'Sin especificar' }}
                    </p>

                    <p class="card-text mt-2">
                        @if($espacio->estado->value == 'HABILITADO')
                        <span class="badge bg-success">Disponible</span>
                        @else
                        <span class="badge bg-danger">Mantenimiento</span>
                        @endif
                    </p>
                </div>

                <div class="card-footer bg-white border-0 text-center pb-3">
                    @if($espacio->estado->value != 'HABILITADO')
                        <button class="btn btn-outline-secondary mt-2 w-100" disabled>
                            No Disponible
                        </button>
                    @else
                        @auth
                            <a href="#" class="btn btn-outline-primary mt-2 w-100">
                                Reservar Ahora
                            </a>
                        @else
                            {{-- se va a mandar al login, no implementado aun--}}
                            <a href="/login" class="btn btn-outline-primary mt-2 w-100">
                                Reservar ahora
                            </a>
                        @endauth
                    @endif
                </div>            border-radius: 8px;

            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <div class="alert alert-warning">
                No hay espacios disponibles en este momento.
            </div>
        </div>
        @endforelse

    </div>
</div>
@endsection
