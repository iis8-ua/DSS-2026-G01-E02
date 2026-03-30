@extends('layouts.master')

@section('title', 'Panel de Administración')

@section('content')
<div class="container my-5 flex-grow-1">

    <div class="d-flex align-items-center mb-4 gap-3">
        <div>
            <h1 class="h3 mb-0" style="color: #003366;">Panel de Administración</h1>
        </div>
    </div>

    {{-- para acceder al crud de cada modulo que hemos hecho--}}
    <div class="row g-4 mb-5">
        {{-- espacios--}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-primary hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0 fw-bold">ESPACIOS</h5>
                    </div>
                    <h2 class="display-5 fw-bold text-dark mb-1">{{ $totalEspacios }}</h2>
                    <br>
                    <a href="{{ route('espacios.index') }}" class="btn btn-primary w-100" style="background-color: #003366; border-color: #003366;">Gestionar Espacios</a>
                </div>
            </div>
        </div>

        {{-- tipo de espacio --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-success hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0 fw-bold">TIPOS DE ESPACIO</h5>
                    </div>
                    <h2 class="display-5 fw-bold text-dark mb-1">{{ $totalTipos }}</h2>
                    <br>
                    <a href="{{ route('tipos-espacio.index') }}" class="btn btn-outline-success w-100">Gestionar Tipos</a>
                </div>
            </div>
        </div>

        {{-- Localizaciones --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-warning hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0 fw-bold">LOCALIZACIONES</h5>
                    </div>
                    <h2 class="display-5 fw-bold text-dark mb-1">{{ $totalLocalizaciones }}</h2>
                    <br>
                    <a href="{{ route('localizaciones.index') }}" class="btn btn-outline-warning w-100">Gestionar Localizaciones</a>
                </div>
            </div>
        </div>

        {{-- Horarios --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-danger hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0 fw-bold">HORARIOS</h5>
                    </div>
                    <h2 class="display-5 fw-bold text-dark mb-1">{{ $totalHorarios }}</h2>
                    <br>
                    <a href="{{ route('horarios.index') }}" class="btn btn-outline-danger w-100">Gestionar Horarios</a>
                </div>
            </div>
        </div>

        {{-- Reservas --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-info hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0 fw-bold">RESERVAS</h5>
                    </div>
                    <h2 class="display-5 fw-bold text-dark mb-1">{{ $totalReservas }}</h2>
                    <br>
                    <a href="{{ route('reservas.index') }}" class="btn btn-outline-info w-100">Gestionar Reservas</a>
                </div>
            </div>
        </div>

        {{-- Incidencias --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-dark hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0 fw-bold">INCIDENCIAS</h5>
                    </div>
                    <h2 class="display-5 fw-bold text-dark mb-1">{{ $totalIncidencias }}</h2>
                    <br>
                    <a href="{{ route('incidencias.index') }}" class="btn btn-outline-dark w-100">Gestionar Incidencias</a>
                </div>
            </div>
        </div>
        {{-- Usuarios --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-info hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0 fw-bold">USUARIOS</h5>
                    </div>
                    <h2 class="display-5 fw-bold text-dark mb-1">{{ $totalUsuarios }}</h2>
                    <br>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-info w-100">Gestionar Usuarios</a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .transition {
        transition: all .3s ease;
    }
</style>
@endsection
