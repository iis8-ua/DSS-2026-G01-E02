@extends('layouts.master')

@section('title', 'Mis reservas')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold text-primary mb-1">Mis reservas</h1>
            <p class="text-muted mb-0">Aquí puedes consultar las reservas que has realizado.</p>
        </div>

        <a href="{{ route('espacios.catalogo') }}" class="btn btn-primary">
            Nueva reserva
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($reservas->isEmpty())
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <h5 class="fw-bold mb-2">No tienes reservas registradas.</h5>
                <p class="text-muted mb-4">Todavía no has hecho ninguna reserva.</p>
                <a href="{{ route('espacios.catalogo') }}" class="btn btn-outline-primary">
                    Ir al catálogo
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($reservas as $reserva)
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                <div>
                                    <h5 class="fw-bold mb-1">
                                        {{ $reserva->espacio->nombre ?? 'Espacio sin nombre' }}
                                    </h5>

                                    <p class="text-muted mb-1">
                                        Fecha:
                                        {{ $reserva->hora_inicio->format('d/m/Y') }}
                                    </p>

                                    <p class="text-muted mb-1">
                                        Hora:
                                        {{ $reserva->hora_inicio->format('H:i') }}
                                        -
                                        {{ $reserva->hora_fin->format('H:i') }}
                                    </p>
                                </div>

                                <div>
                                    <span class="badge bg-secondary fs-6">
                                        {{ $reserva->estado->value }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
