@extends('layouts.master')

@section('title', 'Editar Reserva')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">
                        Editar Reserva: {{ $reserva->espacio->nombre ?? 'Espacio' }}
                        <span class="fs-6 fw-normal text-muted">
                            ({{ $reserva->hora_inicio->format('d/m/Y') }})
                        </span>
                    </h1>
                </div>
                <div class="card-body p-4">

                    {{-- Tarjeta informativa del solicitante --}}
                    <div class="alert alert-secondary d-flex align-items-center mb-4 border-0 shadow-sm">
                        <i class="bi bi-person-circle fs-3 me-3 text-secondary"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Solicitante: {{ $reserva->alumno->getFullName() ?? 'Desconocido' }}</h6>
                        </div>
                    </div>

                    <form action="{{ route('reservas.update', $reserva->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            {{-- Selector de Estado --}}
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Estado de la Reserva</label>
                                <select name="estado" class="form-select fw-bold @error('estado') is-invalid @enderror">
                                    <option value="PENDIENTE"  {{ old('estado', $reserva->estado->value) == 'PENDIENTE'  ? 'selected' : '' }}>Pendiente</option>
                                    <option value="ACEPTADA"   {{ old('estado', $reserva->estado->value) == 'ACEPTADA'   ? 'selected' : '' }}>Aceptada</option>
                                    <option value="RECHAZADA"  {{ old('estado', $reserva->estado->value) == 'RECHAZADA'  ? 'selected' : '' }}>Rechazada</option>
                                    <option value="CANCELADA"  {{ old('estado', $reserva->estado->value) == 'CANCELADA'  ? 'selected' : '' }}>Cancelada</option>
                                </select>
                                @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Selector de Espacio --}}
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Espacio Asignado</label>
                                <select name="espacio_id" class="form-select @error('espacio_id') is-invalid @enderror">
                                    @foreach($espacios as $esp)
                                    <option value="{{ $esp->id }}" {{ old('espacio_id', $reserva->espacio_id) == $esp->id ? 'selected' : '' }}>
                                    {{ $esp->nombre }} (Aforo: {{ $esp->aforo }} - Piso: {{ $esp->loc_piso }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('espacio_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            {{-- Fecha y Hora de Inicio --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Inicio de la Reserva</label>
                                <input type="datetime-local" name="hora_inicio"
                                       value="{{ old('hora_inicio', $reserva->hora_inicio->format('Y-m-d\TH:i')) }}"
                                       class="form-control @error('hora_inicio') is-invalid @enderror">
                                @error('hora_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Fecha y Hora de Fin --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Fin de la Reserva</label>
                                <input type="datetime-local" name="hora_fin"
                                       value="{{ old('hora_fin', $reserva->hora_fin->format('Y-m-d\TH:i')) }}"
                                       class="form-control @error('hora_fin') is-invalid @enderror">
                                @error('hora_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('reservas.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn btn-primary" style="background-color: #003366; border-color: #003366;">
                                Actualizar Reserva
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
