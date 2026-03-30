@extends('layouts.master')

@section('title', 'Gestión de Horarios')

@section('content')
<style>
    .btn-volver {
        background-color: #f8f9fa; /* Gris muy clarito */
        border: 1px solid #dee2e6; /* Borde sutil para que destaque sobre el blanco */
        color: #495057;
        transition: all 0.2s ease-in-out;
    }
    .btn-volver:hover {
        background-color: #e9ecef; /* Se oscurece un poco el fondo */
        color: #003366; /* El texto y el icono pasan a tu azul corporativo */
        border-color: #c1c9d0;
        transform: translateY(-2px); /* Da un pequeño "saltito" hacia arriba */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important; /* La sombra se hace más grande */
    }
</style>
<div class="container my-5 flex-grow-1">
    <div class="bg-white p-5 rounded shadow-sm">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('admin.index') }}" class="btn btn-volver rounded-pill text-decoration-none mb-4 py-2 px-3 d-inline-flex align-items-center shadow-sm">
                <i class="bi bi-arrow-left fs-6 me-2"></i> 
                <span style="font-size: 0.9rem;">Volver al panel</span>
            </a>
            <h1 class="h3 mb-0" style="color: #003366;">Gestión de Horarios</h1>
            <a href="{{ route('horarios.create') }}" class="btn text-white" style="background-color: #003366;">Añadir Nuevo</a>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form method="GET" action="{{ route('horarios.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por hora de inicio o fin...">
                <button type="submit" class="btn btn-dark">Buscar</button>
                <a href="{{ route('horarios.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                <tr>
                    <th>
                        <a href="{{ route('horarios.index', ['buscar' => request('buscar'), 'ordenar_por' => 'inicio', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            Inicio
                            @if(request('ordenar_por', 'inicio') == 'inicio')
                            <span>{{ request('direccion', 'asc') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('horarios.index', ['buscar' => request('buscar'), 'ordenar_por' => 'fin', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            Fin
                            @if(request('ordenar_por') == 'fin')
                            <span>{{ request('direccion') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>
                    <th>Espacios Asignados</th>
                    <th class="text-end" style="width: 150px;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($horarios as $horario)
                <tr>
                    <td class="fw-bold">{{ \Carbon\Carbon::parse($horario->inicio)->format('H:i') }}</td>
                    <td class="fw-bold">{{ \Carbon\Carbon::parse($horario->fin)->format('H:i') }}</td>
                    <td>
                        <span class="badge bg-secondary">
                            {{ $conteosEspacios[$horario->id] ?? 0 }} espacios
                        </span>
                    </td>
                    <td class="text-end">
                        <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Seguro que deseas eliminar este horario?');">
                            <a href="{{ route('horarios.edit', $horario->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Borrar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No hay horarios registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $horarios->links() }}
        </div>

    </div>
</div>
@endsection
