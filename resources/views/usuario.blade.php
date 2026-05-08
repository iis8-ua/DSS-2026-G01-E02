@extends('layouts.master')

@section('title', 'Mi Perfil - EspaciUA')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark" style="color: #003366"><i class="bi bi-person-circle text-primary me-2"></i>Mi Perfil</h2>
        <a href="{{ route('usuario.edit-perfil', $usuario->id) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-pencil"></i> Editar Perfil</a>
    </div>
    {{-- crea el recuadro donde salen los datos personales del usuario --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h4 class="text-dark fw-bold"> Datos Personales</h4>
        </div>
        <div class="card-body">
            {{-- para ponerlo todo en una fila --}}
            <div class="row">
                <div class="col-md-3 mb-3">
                    <span class="text-muted d-block mb-1">Nombre Completo</span>
                    <span class="text-dark fw-bold">{{ $usuario->getFullName() }}</span>
                </div>
                <div class="col-md-3 mb-3">
                    <span class="text-muted d-block mb-1">DNI</span>
                    <span class="text-dark fw-bold">{{ $usuario->dni }}</span>
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">Correo Electrónico</span>
                    <span class="text-dark fw-bold fs-5">{{ $usuario->email }}</span>
                </div>
                <div class="col-md-2 mb-3">
                    <span class="text-muted d-block mb-1">Tipo de Cuenta</span>
                    <span class="text-dark fw-bold fs-5 text-uppercase">{{ $usuario->tipo_usuario }}</span>
                </div>
            </div>
        </div>
    </div>

    @if(str_contains(strtolower($usuario->tipo_usuario), 'admin'))
        @include('components.section_admin')
    @elseif(str_contains(strtolower($usuario->tipo_usuario), 'alumno'))
        @include('components.section_alumno', ['reservas' => $reservas ?? collect()])
    @else
        @include('components.section_personal')
    @endif

    <div class="card shadow-sm border-danger mt-4">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
        <h4 class="text-danger fw-bold">
            <i class="bi bi-exclamation-triangle me-2"></i>Cierre de cuenta
        </h4>
    </div>

    <div class="card-body">
        <p class="text-muted mb-3">
            Desde este apartado puedes cerrar tu cuenta. Esta operación desactivará tu acceso
            al sistema, pero conservará la información necesaria para mantener la trazabilidad
            de reservas, incidencias e historial asociado.
        </p>

        <div class="alert alert-warning">
            <strong>Advertencia:</strong> una vez cerrada la cuenta, no podrás iniciar sesión
            con tus credenciales actuales. Esta acción no elimina físicamente tus datos del sistema.
        </div>

        @error('password')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror

        <form method="POST"
              action="{{ route('usuario.cerrar-cuenta') }}"
              onsubmit="return confirm('¿Seguro que quieres cerrar tu cuenta? Esta acción desactivará tu acceso al sistema.');">
            @csrf
            @method('DELETE')

            <div class="mb-3">
                <label for="password" class="form-label fw-bold">
                    Confirma tu contraseña
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Introduce tu contraseña actual"
                    required
                >

                <small class="text-muted">
                    Por seguridad, necesitamos verificar tu identidad antes de cerrar la cuenta.
                </small>
            </div>

            <button type="submit" class="btn btn-danger">
                <i class="bi bi-person-x me-1"></i>Cerrar cuenta
            </button>
        </form>
    </div>
</div>

</div>
@endsection
