@extends('layouts.master')

@section('title', 'Iniciar sesión - EspaciUA')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 fw-bold text-primary">Iniciar sesión</h1>
                        <p class="text-muted mb-0">
                            Accede a tu cuenta para gestionar tus reservas.
                        </p>
                    </div>

                    <form method="POST" action="#">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo institucional</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="usuario@alu.ua.es"
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

                        <button type="submit" class="btn btn-primary w-100">
                            Entrar
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('espacios.catalogo') }}" class="text-decoration-none">
                            Volver al catálogo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection