@extends('layouts.master')

@section('title', 'Editar Horario')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">
                        Editar Horario: {{ \Carbon\Carbon::parse($horario->inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($horario->fin)->format('H:i') }}
                    </h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('horarios.update', $horario->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Hora de Inicio</label>
                                <input type="time" name="inicio"
                                       value="{{ old('inicio', \Carbon\Carbon::parse($horario->inicio)->format('H:i')) }}"
                                       class="form-control @error('inicio') is-invalid @enderror">
                                @error('inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Hora de Fin</label>
                                <input type="time" name="fin"
                                       value="{{ old('fin', \Carbon\Carbon::parse($horario->fin)->format('H:i')) }}"
                                       class="form-control @error('fin') is-invalid @enderror">
                                @error('fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('horarios.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn btn-primary" style="background-color: #003366; border-color: #003366;">Actualizar Horario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
