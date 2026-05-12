@extends('layouts.master')

@section('title', 'Editar miembros - EspaciUA')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h1 class="h2 fw-bold text-primary">Editar miembros</h1>
        <p class="text-muted mb-0">
            Modifica los miembros de la reserva grupal.
        </p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Espacio</label>
                        <input type="text" class="form-control" value="{{ $reservasGrupal->reserva->espacio->nombre }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha y hora</label>
                        <input type="text" class="form-control" value="{{ $reservasGrupal->reserva->hora_inicio->format('d/m/Y H:i') }} - {{ $reservasGrupal->reserva->hora_fin->format('H:i') }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Aforo máximo del grupo</label>
                        <input type="text" class="form-control" value="{{ $reservasGrupal->aforo_max }} personas" readonly>
                    </div>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('reservas-grupales.actualizarMiembros', $reservasGrupal) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">
                                Miembros del grupo
                                <span class="text-muted small">(máx. {{ $reservasGrupal->aforo_max }} personas)</span>
                            </label>

                            <div class="border rounded p-2" style="max-height: 300px; overflow-y: auto;">

                                {{-- Usuario autenticado: marcado y bloqueado --}}
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

                                {{-- Resto de alumnos --}}
                                @foreach ($alumnos as $alumno)
                                @if ($alumno->id !== auth()->id())
                                <div class="form-check mb-1">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        name="alumnos[]"
                                        value="{{ $alumno->id }}"
                                        id="alumno_{{ $alumno->id }}"
                                        {{ in_array($alumno->id, $alumnosSeleccionados) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="alumno_{{ $alumno->id }}">
                                        {{ $alumno?->name ?? 'Usuario eliminado' }}
                                        <span class="text-muted small">{{ $alumno?->email ?? '' }}</span>
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

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                Guardar cambios
                            </button>
                            <a href="{{ route('reservas.mias') }}" class="btn btn-outline-secondary w-100">
                                Cancelar
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
