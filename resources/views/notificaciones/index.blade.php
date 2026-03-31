@extends('layouts.master')
@section('title', 'Gestión de Notificaciones')
@section('content')
<style>
    .btn-volver {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #495057;
        transition: all 0.2s ease-in-out;
    }
    .btn-volver:hover {
        background-color: #e9ecef;
        color: #003366;
        border-color: #c1c9d0;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
    }
</style>
<div class="container my-5 flex-grow-1">
    <div class="bg-white p-5 rounded shadow-sm">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('admin.index') }}" class="btn btn-volver rounded-pill text-decoration-none mb-4 py-2 px-3 d-inline-flex align-items-center shadow-sm">
                <i class="bi bi-arrow-left fs-6 me-2"></i>
                <span style="font-size: 0.9rem;">Volver al panel</span>
            </a>
            <h1 class="h3 mb-0" style="color: #003366;">Gestión de Notificaciones</h1>
            <a href="{{ route('notificaciones.create') }}" class="btn text-white" style="background-color: #003366;">Añadir Nueva</a>
        </div>

        <form method="GET" action="{{ route('notificaciones.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control"
                       placeholder="Buscar por título, texto o usuario...">
                <button type="submit" class="btn btn-dark">Buscar</button>
                <a href="{{ route('notificaciones.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                <tr>
                    <th>Imagen</th>
                    <th>
                        <a href="{{ route('notificaciones.index', ['buscar' => request('buscar'), 'ordenar_por' => 'id', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            ID
                            @if(request('ordenar_por', 'id') == 'id')
                            <span>{{ request('direccion', 'desc') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('notificaciones.index', ['buscar' => request('buscar'), 'ordenar_por' => 'titulo', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            Título
                            @if(request('ordenar_por') == 'titulo')
                            <span>{{ request('direccion', 'desc') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('notificaciones.index', ['buscar' => request('buscar'), 'ordenar_por' => 'usuario', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            Usuario
                            @if(request('ordenar_por') == 'usuario')
                            <span>{{ request('direccion', 'desc') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>
                    <th>Vista</th>
                    <th>Incidencia</th>
                    <th class="text-end" style="width: 150px;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($notificaciones as $notificacion)
                <tr>
                    <td>
                        @if($notificacion->imagen)
                        <img src="{{ asset('images/notificaciones/' . $notificacion->imagen) }}"
                             alt="Imagen notificación"
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"
                             class="shadow-sm">
                        @else
                        <span class="badge bg-secondary">Sin imagen</span>
                        @endif
                    </td>
                    <td class="fw-bold text-muted">{{ substr($notificacion->id, 0, 8) }}...</td>
                    <td class="text-truncate" style="max-width: 200px;" title="{{ $notificacion->titulo }}">
                        {{ $notificacion->titulo }}
                    </td>
                    <td>{{ $notificacion->usuario->getFullName() ?? 'Usuario Desconocido' }}</td>
                    <td>
                        @if($notificacion->vista)
                        <span class="badge bg-success">Vista</span>
                        @else
                        <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
                    </td>
                    <td>
                        @if($notificacion->hasIncidencia())
                        <span class="badge bg-info text-dark" title="{{ $notificacion->incidencia->descripcion }}">
                            #{{ substr($notificacion->incidencia_id, 0, 8) }}...
                        </span>
                        @else
                        <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <form action="{{ route('notificaciones.destroy', $notificacion->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Seguro que deseas eliminar esta notificación? Si tiene imagen, también se borrará.');">

                            <a href="{{ route('notificaciones.show', $notificacion->id) }}" class="btn btn-sm btn-info text-white" title="Ver Detalles">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('notificaciones.edit', $notificacion->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
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
                <tr><td colspan="7" class="text-center text-muted py-4">No hay notificaciones registradas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $notificaciones->links() }}
        </div>

    </div>
</div>
@endsection
