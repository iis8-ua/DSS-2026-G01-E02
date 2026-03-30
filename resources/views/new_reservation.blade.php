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
            <x-calendar
                :horariosDisponibles="$horariosDisponibles"
                :reservasExistentes="$reservasExistentes"
            />
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h2 class="h5 mb-3">Resumen de la reserva</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reservas.guardarNueva', $espacio) }}">
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
                                value="{{ old('fecha') }}"
                                min="{{ now()->toDateString() }}"
                                max="{{ now()->addDays(5)->toDateString() }}"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="horario" class="form-label">Franja horaria</label>
                            <select
                                class="form-control"
                                id="horario"
                                name="horario"
                                value="{{ old('horario') }}"
                                required
                            >
                                @foreach ($horariosDisponibles as $horario)
                                    <option>
                                        {{ $horario->inicio->format('H:i') }} - {{ $horario->fin->format('H:i') }}
                                    </option>
                                @endforeach
                            </select>
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