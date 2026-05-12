@extends('layouts.master')

@section('title', 'Nueva reserva grupal - EspaciUA')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h1 class="h2 fw-bold text-primary">Nueva reserva grupal</h1>
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

                    <form method="GET" action="{{ route('reservas.nuevaGrupal', $espacio) }}">
                        <div class="mb-3">
                            <label class="form-label">Espacio</label>
                            <input type="text" class="form-control" value="{{ $espacio->nombre }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Aforo máximo</label>
                            <input type="text" class="form-control" value="{{ $espacio->aforo }} personas" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input
                                type="date"
                                class="form-control"
                                id="fecha"
                                name="fecha"
                                value="{{ $fecha ?? old('fecha') }}"
                                min="{{ now()->toDateString() }}"
                                max="{{ now()->addDays(5)->toDateString() }}"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-secondary w-100 mb-3">
                            Ver disponibilidad
                        </button>
                    </form>

                    @if (isset($fecha) && $fecha)
                    <form method="POST" action="{{ route('reservas.guardarNuevaGrupal', $espacio) }}">
                        @csrf
                        <input type="hidden" name="fecha" value="{{ $fecha }}">

                        <div class="mb-3">
                            <label for="horario" class="form-label">Franja horaria</label>
                            <select class="form-control" id="horario" name="horario" required>
                                @foreach ($horariosDisponibles as $horario)
                                @php
                                $ocupado = $horariosOcupados->contains(function ($reserva) use ($horario) {
                                return $reserva->hora_inicio->format('H:i') === $horario->inicio->format('H:i')
                                && $reserva->hora_fin->format('H:i') === $horario->fin->format('H:i');
                                });
                                @endphp
                                @if (!$ocupado)
                                <option value="{{ $horario->inicio->format('H:i') }} - {{ $horario->fin->format('H:i') }}">
                                    {{ $horario->inicio->format('H:i') }} - {{ $horario->fin->format('H:i') }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="aforo_max" class="form-label">Aforo máximo del grupo</label>
                            <input
                                type="number"
                                class="form-control"
                                id="aforo_max"
                                name="aforo_max"
                                min="2"
                                max="{{ $espacio->aforo }}"
                                value="{{ old('aforo_max') }}"
                                placeholder="Entre 2 y {{ $espacio->aforo }}"
                                required
                            >
                            <small class="text-muted">Debe ser al menos el número de miembros seleccionados y no superar el aforo del espacio ({{ $espacio->aforo }}).</small>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="form-label">
                                Miembros del grupo
                                <span class="text-muted small">(máx. {{ $espacio->aforo }} personas)</span>
                            </label>

                            <div class="border rounded p-2" style="max-height: 250px; overflow-y: auto;">

                                <div class="form-check mb-1">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        checked
                                        disabled
                                    >
                                    <input type="hidden" name="alumnos[]" value="{{ auth()->id() }}">
                                    <label class="form-check-label fw-bold">
                                        {{ auth()->user()->name }} <span class="text-muted">(tú)</span>
                                    </label>
                                </div>

                                @php $seleccionados = count(old('alumnos', [])); @endphp
                                @foreach ($alumnos as $alumno)
                                @if ($alumno->id !== auth()->id())
                                @php
                                $checked = in_array($alumno->id, old('alumnos', []));
                                @endphp
                                <div class="form-check mb-1">
                                    <input
                                        type="checkbox"
                                        class="form-check-input alumno-check"
                                        name="alumnos[]"
                                        value="{{ $alumno->id }}"
                                        id="alumno_{{ $alumno->id }}"
                                        {{ $checked ? 'checked' : '' }}
                                    data-aforo="{{ $espacio->aforo }}"
                                    >
                                    <label class="form-check-label" for="alumno_{{ $alumno->id }}">
                                        {{ $alumno->name }}
                                        <span class="text-muted small">{{ $alumno->email }}</span>
                                    </label>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            <small class="text-muted">El organizador de la reserva siempre está incluido.</small>

                            @error('alumnos')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Confirmar reserva grupal
                        </button>
                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
