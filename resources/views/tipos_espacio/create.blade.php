@extends('layouts.master')

@section('title', 'Crear Tipo de Espacio')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">Añadir Tipo de Espacio</h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('tipos-espacio.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nombre del Tipo</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ej. Aula de Teoría" autofocus>

                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('tipos-espacio.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn text-white" style="background-color: #003366;">Guardar Tipo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
