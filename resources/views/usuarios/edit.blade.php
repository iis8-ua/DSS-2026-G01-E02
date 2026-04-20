@extends('layouts.master')

@section('title', 'Editar Usuario')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                    <h1 class="h4 mb-0" style="color: #003366;">Editar Usuario: {{ $usuario->name }}</h1>
                </div>
                <div class="card-body p-4">
                    {{-- Apuntamos al método update y pasamos el ID del usuario --}}
                    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Petición PUT para actualizar --}}

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nombre</label>
                                <input type="text" name="nombre" value="{{ old('nombre', $usuario->name) }}" class="form-control @error('nombre') is-invalid @enderror" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <label class="form-label fw-bold">Apellidos</label>
                                <input type="text" name="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}" class="form-control @error('apellidos') is-invalid @enderror" required>
                                @error('apellidos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">DNI</label>
                                <input type="text" name="dni" value="{{ old('dni', $usuario->dni) }}" class="form-control @error('dni') is-invalid @enderror" required>
                                @error('dni')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <label class="form-label fw-bold">Correo Electrónico</label>
                                <input type="email" name="email" value="{{ old('email', $usuario->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nueva Contraseña <span class="text-muted fw-normal">(Opcional)</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Dejar en blanco para mantenerla">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <label class="form-label fw-bold">Tipo de Cuenta</label>
                                <select name="tipo_usuario" class="form-select @error('tipo_usuario') is-invalid @enderror" required>
                                    <option value="alumno" {{ old('tipo_usuario', $usuario->tipo_usuario) == 'alumno' ? 'selected' : '' }}>Alumno</option>
                                    
                                    <option value="gestor_espacios" {{ (old('tipo_usuario', $usuario->tipo_usuario) == 'gestor_espacios' || old('tipo_usuario', $usuario->tipo_usuario) == 'gestor') ? 'selected' : '' }}>Gestor</option>
                                    <option value="admin" {{ old('tipo_usuario', $usuario->tipo_usuario) == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('tipo_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn text-white" style="background-color: #003366;">Actualizar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
