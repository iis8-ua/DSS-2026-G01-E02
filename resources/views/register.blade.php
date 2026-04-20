@extends('layouts.master')

@section('title', 'Registrarse - EspaciUA')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h1 class="h3 fw-bold text-primary">Crea una cuenta</h1>
                            <p class="text-muted mb-0">
                                Regístrate para continuar
                            </p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control " id="nombre" placeholder="Nombre"  />
                                </div>

                                <div class="col mb-3">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input type="text" name="apellidos" class="form-control " id="apellidos" placeholder="Apellidos"  />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" name="dni" class="form-control " id="dni" placeholder="00000000A"  />
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="ejemplo@ejemplo.com"
                                    required
                                >
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Introduce tu contraseña"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <p>Registrarme como:</p>

                                <div class="form-check">
                                    <input type="radio" name="tipo_usuario" value="ALUMNO" class="form-check-input">
                                    <label class="form-check-label">Alumno</label>
                                </div>

                                <div class="form-check">
                                    <input type="radio" name="tipo_usuario" value="GESTOR" class="form-check-input">
                                    <label class="form-check-label">Gestor</label>
                                </div>
                            </div>

                            @error('email')
                            <div class="invalid-feedback d-block m-3">
                                {{ $message }}
                            </div>
                            @enderror


                            <p>
                                ¿Ya eres usuario? <a href="{{ route('login') }}">Inicia sesión.</a>
                            </p>

                            <button type="submit" class="btn btn-primary w-100">
                                Registrarse
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
