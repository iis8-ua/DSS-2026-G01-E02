@extends('layouts.master')

@section('title', 'Añadir Notificación')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">Crear Nueva Notificación</h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('notificaciones.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Usuario</label>
                            <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                <option value="">Seleccione un usuario...</option>
                                @foreach($usuarios as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->getFullName() }} ({{ $user->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Título</label>
                            <input type="text" name="titulo"
                                   class="form-control @error('titulo') is-invalid @enderror"
                                   placeholder="Título de la notificación..."
                                   value="{{ old('titulo') }}">
                            @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Texto</label>
                            <textarea name="texto"
                                      class="form-control @error('texto') is-invalid @enderror"
                                      rows="5"
                                      placeholder="Contenido de la notificación...">{{ old('texto') }}</textarea>
                            @error('texto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Incidencia relacionada <span class="text-muted fw-normal">(Opcional)</span></label>
                            <select name="incidencia_id" class="form-select @error('incidencia_id') is-invalid @enderror">
                                <option value="">Sin incidencia asociada</option>
                                @foreach($incidencias as $incidencia)
                                <option value="{{ $incidencia->id }}" {{ old('incidencia_id') == $incidencia->id ? 'selected' : '' }}>
                                #{{ substr($incidencia->id, 0, 8) }}... — {{ Str::limit($incidencia->descripcion, 60) }}
                                </option>
                                @endforeach
                            </select>
                            @error('incidencia_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="vista" id="vista" value="1"
                                       {{ old('vista') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="vista">
                                    Marcar como vista
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Imagen adjunta <span class="text-muted fw-normal">(Opcional)</span></label>
                            <input type="file" name="imagen"
                                   class="form-control @error('imagen') is-invalid @enderror"
                                   accept="image/png, image/jpeg, image/jpg">
                            <div class="form-text">Formatos permitidos: JPG, PNG. Tamaño máximo: 2MB.</div>
                            @error('imagen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('notificaciones.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn text-white" style="background-color: #003366;">Guardar Notificación</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
