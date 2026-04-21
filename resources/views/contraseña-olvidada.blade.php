@extends('layouts.master')

@section('title', 'Recuperar contraseña - EspaciUA')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 fw-bold text-primary">Recuperar contraseña</h1>
                        <p class="text-muted mb-0">
                            Introduce tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                        </p>
                    </div>

                    {{-- Mensaje si se envía el correo --}}
                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                placeholder="ejemplo@ejemplo.com"
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Enviar enlace para recuperar contraseña
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">¿Te has acordado? <a href="{{ route('login') }}" class="text-decoration-none">Volver a Iniciar sesión</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection