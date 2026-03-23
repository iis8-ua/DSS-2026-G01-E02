@extends('layouts.master')

@section('title', 'Añadir Espacio')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">Añadir Nuevo Espacio</h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('espacios.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nombre del Espacio</label>
                                <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ej. Aula 101">
                                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">Aforo Máximo</label>
                                <input type="number" name="aforo" value="{{ old('aforo') }}" class="form-control @error('aforo') is-invalid @enderror" placeholder="Ej. 30">
                                @error('aforo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">Estado</label>
                                <select name="estado" class="form-select @error('estado') is-invalid @enderror">
                                    @foreach($estados as $est)
                                    <option value="{{ $est->value }}" {{ old('estado', 'HABILITADO') == $est->value ? 'selected' : '' }}>{{ $est->name }}</option>
                                    @endforeach
                                </select>
                                @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tipo de Espacio</label>
                                <select name="tipo_espacio_id" class="form-select @error('tipo_espacio_id') is-invalid @enderror">
                                    <option value="">Seleccione tipo...</option>
                                    @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}" {{ old('tipo_espacio_id') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('tipo_espacio_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Localización</label>
                                <select name="localizacion_compuesta" class="form-select @error('localizacion_compuesta') is-invalid @enderror">
                                    <option value="">Seleccione localización...</option>
                                    @foreach($localizaciones as $loc)
                                    @php $valLoc = $loc->latitud . '_' . $loc->longitud . '_' . $loc->piso; @endphp
                                    <option value="{{ $valLoc }}" {{ old('localizacion_compuesta') == $valLoc ? 'selected' : '' }}>
                                    Piso {{ $loc->piso }} ({{ $loc->latitud }}, {{ $loc->longitud }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('localizacion_compuesta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Horario Base</label>
                                <select name="horario_compuesto" class="form-select @error('horario_compuesto') is-invalid @enderror">
                                    <option value="">Seleccione horario...</option>
                                    @foreach($horarios as $hor)
                                    @php $valHor = $hor->inicio . '_' . $hor->fin; @endphp
                                    <option value="{{ $valHor }}" {{ old('horario_compuesto') == $valHor ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($hor->inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($hor->fin)->format('H:i') }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('horario_compuesto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Características Adicionales</label>
                            <textarea name="caracteristicas" class="form-control @error('caracteristicas') is-invalid @enderror" rows="3" placeholder="Ej. Proyector, Pizarra digital, Aire acondicionado...">{{ old('caracteristicas') }}</textarea>
                            @error('caracteristicas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Fotografía del Espacio (Opcional)</label>
                            <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @enderror" accept="image/png, image/jpeg, image/jpg">
                            <div class="form-text">Formatos permitidos: JPG, PNG. Tamaño máximo: 2MB.</div>
                            @error('imagen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('espacios.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn text-white" style="background-color: #003366;">Guardar Espacio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
