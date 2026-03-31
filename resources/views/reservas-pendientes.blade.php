@extends('layouts.master')
@section('title', 'Reservas Pendientes')
@section('content')

<div class="container my-5 flex-grow-1">
    <div class="bg-white p-5 rounded shadow-sm">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0" style="color: #003366;">Reservas Pendientes de Aceptación</h1>
            <span class="badge bg-warning text-dark fs-6">{{ $reservas->total() }} pendiente(s)</span>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                <tr>
                    <th>Espacio</th>
                    <th>Usuario</th>
                    <th>Hora inicio</th>
                    <th>Hora fin</th>
                    <th style="width: 120px;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($reservas as $reserva)
                <tr>
                    <td class="fw-bold">{{ $reserva->espacio->nombre }}</td>
                    <td>
                        <div>{{ $reserva->alumno->name }}</div>
                        <small class="text-muted">{{ $reserva->alumno->email }}</small>
                    </td>
                    <td>{{ $reserva->hora_inicio->format('d/m/Y H:i') }}</td>
                    <td>{{ $reserva->hora_fin->format('d/m/Y H:i') }}</td>
                    <td>
                        {{-- Aceptar --}}
                        <form action="{{ route('gestor.reservas.aceptar', $reserva->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-success" title="Aceptar">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </form>

                        {{-- Rechazar --}}
                        <form action="{{ route('gestor.reservas.rechazar', $reserva->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Seguro que deseas rechazar esta reserva?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Rechazar">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="bi bi-check-circle text-success fs-4 me-2"></i>
                        No hay reservas pendientes de aceptación.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $reservas->links() }}
        </div>

    </div>
</div>
@endsection
