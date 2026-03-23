@extends('layouts.master')

@section('title', 'Editar Tipo de Espacio')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">Editar Tipo de Espacio</h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('tipos-espacio.update', $tipo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold">Nombre del Tipo</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $tipo->nombre) }}" class="form-control @error('nombre') is-invalid @enderror">

                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('tipos-espacio.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
