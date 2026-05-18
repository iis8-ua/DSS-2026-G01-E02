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
                                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" placeholder="Nombre" value="{{ old('nombre') }}" required />
                                    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col mb-3">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" id="apellidos" placeholder="Apellidos" value="{{ old('apellidos') }}" required />
                                    @error('apellidos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" name="dni" class="form-control @error('dni') is-invalid @enderror" id="dni" placeholder="00000000A" value="{{ old('dni') }}" required />
                                @error('dni') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="ejemplo@ejemplo.com" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Introduce tu contraseña (mínimo 6 caracteres)" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>


                            <p>¿Ya eres usuario? <a href="{{ route('login') }}">Inicia sesión.</a></p>

                            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
