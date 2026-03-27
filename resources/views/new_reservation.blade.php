@extends('layouts.master')

@section('title', 'Nueva reserva - EspaciUA')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h1 class="h2 fw-bold text-primary">Nueva reserva</h1>
        <p class="text-muted mb-0">
            Completa los datos para reservar el espacio seleccionado.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <x-calendar />
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h2 class="h5 mb-3">Resumen de la reserva</h2>

                    <form method="POST" action="#">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Espacio</label>
                            <input
                                type="text"
                                class="form-control"
                                value="{{ $espacio->nombre }}"
                                readonly
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Aforo</label>
                            <input
                                type="text"
                                class="form-control"
                                value="{{ $espacio->aforo }} personas"
                                readonly
                            >
                        </div>

                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input
                                type="date"
                                class="form-control"
                                id="fecha"
                                name="fecha"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="hora_inicio" class="form-label">Hora de inicio</label>
                            <input
                                type="time"
                                class="form-control"
                                id="hora_inicio"
                                name="hora_inicio"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="hora_fin" class="form-label">Hora de fin</label>
                            <input
                                type="time"
                                class="form-control"
                                id="hora_fin"
                                name="hora_fin"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Confirmar reserva
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection