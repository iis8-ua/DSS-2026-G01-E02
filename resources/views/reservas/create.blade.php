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
                                    {{ $usuario->getFullName() }}
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
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Estado</label>
                                <select name="estado" class="form-select @error('estado') is-invalid @enderror">
                                    <option value="PENDIENTE"  {{ old('estado', 'PENDIENTE') == 'PENDIENTE'  ? 'selected' : '' }}>Pendiente</option>
                                    <option value="ACEPTADA"   {{ old('estado') == 'ACEPTADA'   ? 'selected' : '' }}>Aceptada</option>
                                    <option value="RECHAZADA"  {{ old('estado') == 'RECHAZADA'  ? 'selected' : '' }}>Rechazada</option>
                                    <option value="CANCELADA"  {{ old('estado') == 'CANCELADA'  ? 'selected' : '' }}>Cancelada</option>
                                </select>
                                @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
@endsection
