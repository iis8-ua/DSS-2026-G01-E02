@extends('layouts.master')

@section('title', 'Editar Incidencia')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">Editar Incidencia</h1>
                    <p class="text-muted small">Ref: {{ $incidencia->id }}</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('incidencias.update', $incidencia->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Usuario</label>
                            <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                @foreach($usuarios as $user)
                                <option value="{{ $user->id }}"
                                        {{ old('user_id', $incidencia->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->getFullName() }} ({{ $user->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Descripción de la incidencia</label>
                            <textarea name="descripcion"
                                      class="form-control @error('descripcion') is-invalid @enderror"
                                      rows="5">{{ old('descripcion', $incidencia->descripcion) }}</textarea>
                            @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4 d-flex align-items-center gap-3 bg-light p-3 rounded border">
                            @if($incidencia->foto)
                            <div>
                                <p class="small text-muted mb-1 text-center">Foto actual</p>
                                <img src="{{ asset('images/incidencias/' . $incidencia->foto) }}"
                                     class="rounded shadow-sm"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            @endif
                            <div class="flex-grow-1">
                                <label class="form-label fw-bold">Sustituir Fotografía (Dejar en blanco para mantener la actual)</label>
                                <input type="file" name="foto"
                                       class="form-control @error('foto') is-invalid @enderror"
                                       accept="image/png, image/jpeg, image/jpg">
                                @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('incidencias.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn btn-primary"
                                    style="background-color: #003366; border-color: #003366;">
                                Actualizar Incidencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
