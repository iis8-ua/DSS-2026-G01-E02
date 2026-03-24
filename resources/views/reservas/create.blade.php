@extends('layouts.master')

@section('title', 'Añadir Reserva')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">Añadir Nueva Reserva</h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('reservas.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            {{-- Selector de Solicitante --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Solicitante (Alumno)</label>
                                <select name="alumno_id" class="form-select @error('alumno_id') is-invalid @enderror">
                                    <option value="">Seleccione solicitante...</option>
                                    @foreach($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" {{ old('alumno_id') == $usuario->id ? 'selected' : '' }}>
                                            {{ $usuario->nombre ?? $usuario->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('alumno_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Selector de Espacio --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Espacio</label>
                                <select name="espacio_id" class="form-select @error('espacio_id') is-invalid @enderror">
                                    <option value="">Seleccione espacio...</option>
                                    @foreach($espacios as $espacio)
                                        <option value="{{ $espacio->id }}" {{ old('espacio_id') == $espacio->id ? 'selected' : '' }}>
                                            {{ $espacio->nombre }} (Aforo Max: {{ $espacio->aforo }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('espacio_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            {{-- Fecha y Hora de Inicio --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Inicio de la Reserva</label>
                                <input type="datetime-local" name="hora_inicio" value="{{ old('hora_inicio') }}" class="form-control @error('hora_inicio') is-invalid @enderror">
                                @error('hora_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Fecha y Hora de Fin --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Fin de la Reserva</label>
                                <input type="datetime-local" name="hora_fin" value="{{ old('hora_fin') }}" class="form-control @error('hora_fin') is-invalid @enderror">
                                @error('hora_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            {{-- Estado de la reserva --}}
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Estado</label>
                                <select name="estado" class="form-select @error('estado') is-invalid @enderror">
                                    <option value="PENDIENTE" {{ old('estado', 'PENDIENTE') == 'PENDIENTE' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="ACEPTADA" {{ old('estado') == 'ACEPTADA' ? 'selected' : '' }}>Aceptada / Aprobada</option>
                                    <option value="CANCELADA" {{ old('estado') == 'CANCELADA' ? 'selected' : '' }}>Cancelada / Rechazada</option>
                                </select>
                                @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Seleccionar el tipo de reserva --}}
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tipo de Reserva</label>
                                <select name="tipo_reserva" id="tipo_reserva" class="form-select @error('tipo_reserva') is-invalid @enderror">
                                    <option value="individual" {{ old('tipo_reserva', 'individual') == 'individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="grupal" {{ old('tipo_reserva') == 'grupal' ? 'selected' : '' }}>Grupal</option>
                                </select>
                                @error('tipo_reserva')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Aforo máximo para reservas grupales --}}
                            <div class="col-md-4" id="div_aforo_max" style="display: none;">
                                <label class="form-label fw-bold">Aforo Solicitado</label>
                                <input type="number" name="aforo_max" id="aforo_max" value="{{ old('aforo_max') }}" class="form-control @error('aforo_max') is-invalid @enderror" placeholder="Ej. 5">
                                <div class="form-text">Obligatorio si es reserva grupal.</div>
                                @error('aforo_max')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('reservas.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn text-white" style="background-color: #003366;">Guardar Reserva</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- script para mostrar el campo de aforo si es grupal --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectTipo = document.getElementById('tipo_reserva');
        const divAforo = document.getElementById('div_aforo_max');

        function toggleAforo() {
            if (selectTipo.value === 'grupal') {
                divAforo.style.display = 'block';
            } else {
                divAforo.style.display = 'none';
                // si vulve a individual, limpiamos
                document.getElementById('aforo_max').value = '';
            }
        }

        // cargamos la página
        toggleAforo();

        // ponemos que se ejecuta cada vez que se cambie el tipo de reserva
        selectTipo.addEventListener('change', toggleAforo);
    });
</script>
@endsection