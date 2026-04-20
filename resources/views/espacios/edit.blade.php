@extends('layouts.master')

@section('title', 'Editar Espacio')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">Editar Espacio: {{ $espacio->nombre }}</h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('espacios.update', $espacio->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nombre del Espacio</label>
                                <input type="text" name="nombre"
                                       value="{{ old('nombre', $espacio->nombre) }}"
                                       class="form-control @error('nombre') is-invalid @enderror">
                                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">Aforo Máximo</label>
                                <input type="number" name="aforo" min="0" max="9999"
                                       value="{{ old('aforo', $espacio->aforo) }}"
                                       class="form-control @error('aforo') is-invalid @enderror">
                                @error('aforo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">Estado</label>
                                <select name="estado" class="form-select @error('estado') is-invalid @enderror">
                                    @foreach($estados as $est)
                                    <option value="{{ $est->value }}"
                                            {{ old('estado', $espacio->estado->value) == $est->value ? 'selected' : '' }}>
                                    {{ $est->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tipo de Espacio</label>
                                <select name="tipo_espacio_id" class="form-select @error('tipo_espacio_id') is-invalid @enderror">
                                    @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}"
                                            {{ old('tipo_espacio_id', $espacio->tipo_espacio_id) == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nombre }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('tipo_espacio_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Localización</label>
                                <select name="localizacion_id" class="form-select @error('localizacion_id') is-invalid @enderror">
                                    @foreach($localizaciones as $loc)
                                    <option value="{{ $loc->id }}"
                                            {{ old('localizacion_id', $espacio->localizacion_id) == $loc->id ? 'selected' : '' }}>
                                    Piso {{ $loc->piso }} ({{ $loc->latitud }}, {{ $loc->longitud }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('localizacion_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Franjas Horarias</label>
                                <select name="horarios_ids[]" multiple
                                        class="form-select @error('horarios_ids') is-invalid @enderror"
                                        style="height: 120px;">
                                    @foreach($horarios as $hor)
                                    <option value="{{ $hor->id }}"
                                            {{ in_array($hor->id, old('horarios_ids', $horariosActivos)) ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::parse($hor->inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($hor->fin)->format('H:i') }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Mantén Ctrl para seleccionar varias franjas.</div>
                                @error('horarios_ids')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Características Adicionales</label>
                            <textarea name="caracteristicas"
                                      class="form-control @error('caracteristicas') is-invalid @enderror"
                                      rows="3">{{ old('caracteristicas', $espacio->caracteristicas) }}</textarea>
                            @error('caracteristicas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4 d-flex align-items-center gap-3 bg-light p-3 rounded border">
                            @if($espacio->imagen)
                            <div>
                                <p class="small text-muted mb-1 text-center">Imagen actual</p>
                                <img src="{{ asset('images/espacios/' . $espacio->imagen) }}"
                                     class="rounded shadow-sm"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            @endif
                            <div class="flex-grow-1">
                                <label class="form-label fw-bold">Sustituir Fotografía (Dejar en blanco para mantener la actual)</label>
                                <input type="file" name="imagen"
                                       class="form-control @error('imagen') is-invalid @enderror"
                                       accept="image/png, image/jpeg, image/jpg">
                                @error('imagen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('espacios.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn btn-primary"
                                    style="background-color: #003366; border-color: #003366;">
                                Actualizar Espacio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
