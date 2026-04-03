@extends('layouts.master')

@section('title', 'Editar Localización')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">Editar Localización</h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('localizaciones.update', $localizacion->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Latitud</label>
                                <input type="text" name="latitud" value="{{ old('latitud', $localizacion->latitud) }}" class="form-control @error('latitud') is-invalid @enderror">
                                @error('latitud')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Longitud</label>
                                <input type="text" name="longitud" value="{{ old('longitud', $localizacion->longitud) }}" class="form-control @error('longitud') is-invalid @enderror">
                                @error('longitud')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Piso</label>
                                <input type="number" name="piso" value="{{ old('piso', $localizacion->piso) }}" class="form-control @error('piso') is-invalid @enderror">
                                @error('piso')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('localizaciones.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
