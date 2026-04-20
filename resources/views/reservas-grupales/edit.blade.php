@extends('layouts.master')

@section('title', 'Editar Reserva Grupal')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">Editar Reserva Grupal</h1>
                    <p class="text-muted small">Ref: {{ substr($reservasGrupal->reserva_id, 0, 8) }}...</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('reservas-grupales.update', $reservasGrupal) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Reserva asociada</label>
                            <select name="reserva_id" class="form-select @error('reserva_id') is-invalid @enderror">
                                @foreach($reservas as $reserva)
                                <option value="{{ $reserva->id }}"
                                        {{ old('reserva_id', $reservasGrupal->reserva_id) == $reserva->id ? 'selected' : '' }}>
                                #{{ substr($reserva->id, 0, 8) }}...
                                — {{ $reserva->espacio->nombre ?? 'Sin espacio' }}
                                — {{ $reserva->alumno->getFullName() ?? 'Sin alumno' }}
                                ({{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('d/m/Y H:i') }})
                                </option>
                                @endforeach
                            </select>
                            @error('reserva_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Aforo máximo</label>
                            <input type="number" name="aforo_max" min="1"
                                   class="form-control @error('aforo_max') is-invalid @enderror"
                                   value="{{ old('aforo_max', $reservasGrupal->aforo_max) }}">
                            @error('aforo_max')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Alumnos del grupo</label>

                            @if($reservasGrupal->alumnos->count() > 0)
                            <div class="mb-2 p-2 bg-light rounded border d-flex flex-wrap gap-2">
                                @foreach($reservasGrupal->alumnos as $alumno)
                                <span class="badge bg-primary">{{ $alumno->getFullName() }}</span>
                                @endforeach
                            </div>
                            @else
                            <p class="text-muted small mb-2">Sin alumnos asignados actualmente.</p>
                            @endif

                            <select name="alumnos[]" class="form-select @error('alumnos') is-invalid @enderror" multiple size="7">
                                @foreach($alumnos as $alumno)
                                <option value="{{ $alumno->id }}"
                                        {{ in_array($alumno->id, old('alumnos', $alumnosSeleccionados)) ? 'selected' : '' }}>
                                    {{ $alumno->getFullName() }} ({{ $alumno->email }})
                                </option>
                                @endforeach
                            </select>
                            <div class="form-text">Mantén pulsado Ctrl (o Cmd en Mac) para seleccionar varios. La selección reemplazará la lista actual.</div>
                            @error('alumnos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('reservas-grupales.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn btn-primary"
                                    style="background-color: #003366; border-color: #003366;">
                                Actualizar Reserva Grupal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
