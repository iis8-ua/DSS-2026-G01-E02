@extends('layouts.master')

@section('title', 'Editar Notificación')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">Editar Notificación</h1>
                    <p class="text-muted small">Ref: {{ $notificacion->id }}</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('notificaciones.update', $notificacion->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Usuario</label>
                            <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                @foreach($usuarios as $user)
                                <option value="{{ $user->id }}"
                                        {{ old('user_id', $notificacion->user_id) == $user->id ? 'selected' : '' }}>
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
                                   value="{{ old('titulo', $notificacion->titulo) }}">
                            @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Texto</label>
                            <textarea name="texto"
                                      class="form-control @error('texto') is-invalid @enderror"
                                      rows="5">{{ old('texto', $notificacion->texto) }}</textarea>
                            @error('texto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Incidencia relacionada <span class="text-muted fw-normal">(Opcional)</span></label>
                            <select name="incidencia_id" class="form-select @error('incidencia_id') is-invalid @enderror">
                                <option value="">Sin incidencia asociada</option>
                                @foreach($incidencias as $incidencia)
                                <option value="{{ $incidencia->id }}"
                                        {{ old('incidencia_id', $notificacion->incidencia_id) == $incidencia->id ? 'selected' : '' }}>
                                #{{ substr($incidencia->id, 0, 8) }}... — {{ Str::limit($incidencia->descripcion, 60) }}
                                </option>
                                @endforeach
                            </select>
                            @error('incidencia_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="vista" id="vista" value="1"
                                       {{ old('vista', $notificacion->vista) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="vista">
                                    Marcar como vista
                                </label>
                            </div>
                        </div>

                        <div class="mb-4 d-flex align-items-center gap-3 bg-light p-3 rounded border">
                            @if($notificacion->imagen)
                            <div>
                                <p class="small text-muted mb-1 text-center">Imagen actual</p>
                                <img src="{{ asset('images/notificaciones/' . $notificacion->imagen) }}"
                                     class="rounded shadow-sm"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            @endif
                            <div class="flex-grow-1">
                                <label class="form-label fw-bold">Sustituir Imagen <span class="text-muted fw-normal">(Dejar en blanco para mantener la actual)</span></label>
                                <input type="file" name="imagen"
                                       class="form-control @error('imagen') is-invalid @enderror"
                                       accept="image/png, image/jpeg, image/jpg">
                                @error('imagen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('notificaciones.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn btn-primary"
                                    style="background-color: #003366; border-color: #003366;">
                                Actualizar Notificación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
