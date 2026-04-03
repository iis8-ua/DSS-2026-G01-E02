@extends('layouts.master')

@section('title', 'Añadir Localización')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">Añadir Localización</h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('localizaciones.store') }}" method="POST">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Latitud</label>
                                <input type="text" name="latitud" value="{{ old('latitud') }}" class="form-control @error('latitud') is-invalid @enderror" placeholder="Ej. 38.3845">
                                @error('latitud')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Longitud</label>
                                <input type="text" name="longitud" value="{{ old('longitud') }}" class="form-control @error('longitud') is-invalid @enderror" placeholder="Ej. -0.5132">
                                @error('longitud')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Piso</label>
                                <input type="number" name="piso" value="{{ old('piso') }}" class="form-control @error('piso') is-invalid @enderror" placeholder="Ej. 2">
                                @error('piso')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('localizaciones.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn text-white" style="background-color: #003366;">Guardar Localización</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
