@extends('layouts.master')

@section('title', 'Añadir Reserva Grupal')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">Crear Nueva Reserva Grupal</h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('reservas-grupales.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Reserva asociada</label>
                            <select name="reserva_id" class="form-select @error('reserva_id') is-invalid @enderror">
                                <option value="">Seleccione una reserva...</option>
                                @foreach($reservas as $reserva)
                                <option value="{{ $reserva->id }}" {{ old('reserva_id') == $reserva->id ? 'selected' : '' }}>
                                #{{ substr($reserva->id, 0, 8) }}...
                                — {{ $reserva->espacio->nombre ?? 'Sin espacio' }}
                                — {{ $reserva->alumno->getFullName() ?? 'Sin alumno' }}
                                ({{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('d/m/Y H:i') }})
                                </option>
                                @endforeach
                            </select>
                            <div class="form-text">Selecciona la reserva a la que pertenece este grupo.</div>
                            @error('reserva_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Aforo máximo</label>
                            <input type="number" name="aforo_max" min="1" max="10000"
                                   class="form-control @error('aforo_max') is-invalid @enderror"
                                   placeholder="Número máximo de participantes..."
                                   value="{{ old('aforo_max') }}">
                            @error('aforo_max')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Alumnos del grupo <span class="text-muted fw-normal">(Opcional)</span></label>
                            <div class="border rounded p-2 @error('alumnos') is-invalid @enderror" style="max-height: 180px; overflow-y: auto;">
                                @foreach($alumnos as $alumno)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="alumnos[]"
                                           value="{{ $alumno->id }}"
                                           id="alumno_{{ $alumno->id }}"
                                           {{ in_array($alumno->id, old('alumnos', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="alumno_{{ $alumno->id }}">
                                        {{ $alumno->getFullName() }} ({{ $alumno->email }})
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('alumnos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('reservas-grupales.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn text-white" style="background-color: #003366;">Guardar Reserva Grupal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
