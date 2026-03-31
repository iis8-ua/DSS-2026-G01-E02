@extends('layouts.master')

@section('title', 'Gestión de Espacios')

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
        <a href="{{ route('admin.index') }}" class="btn btn-volver rounded-pill text-decoration-none mb-4 py-2 px-3 d-inline-flex align-items-center shadow-sm">
            <i class="bi bi-arrow-left fs-6 me-2"></i>
            <span style="font-size: 0.9rem;">Volver al panel</span>
        </a>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0" style="color: #003366;">Gestión de Espacios</h1>
            <a href="{{ route('espacios.create') }}" class="btn text-white" style="background-color: #003366;">Añadir Nuevo</a>
        </div>

        <form method="GET" action="{{ route('espacios.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por nombre, estado o aforo...">
                <button type="submit" class="btn btn-dark">Buscar</button>
                <a href="{{ route('espacios.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                <tr>
                    <th>Imagen</th>
                    <th>
                        <a href="{{ route('espacios.index', ['buscar' => request('buscar'), 'ordenar_por' => 'nombre', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            Nombre
                            @if(request('ordenar_por', 'nombre') == 'nombre')
                            <span>{{ request('direccion', 'asc') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>
                    <th>Tipo</th>
                    <th>Piso</th>
                    <th>
                        <a href="{{ route('espacios.index', ['buscar' => request('buscar'), 'ordenar_por' => 'aforo', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            Aforo
                            @if(request('ordenar_por') == 'aforo')
                            <span>{{ request('direccion') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>
                    <th>Estado</th>
                    <th class="text-end" style="width: 150px;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($espacios as $espacio)
                <tr>
                    <td>
                        @if($espacio->imagen)
                        <img src="{{ asset('images/espacios/' . $espacio->imagen) }}"
                             alt="{{ $espacio->nombre }}"
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"
                             class="shadow-sm">
                        @else
                        <span class="badge bg-secondary">Sin imagen</span>
                        @endif
                    </td>
                    <td class="fw-bold">{{ $espacio->nombre }}</td>
                    <td>{{ $espacio->tipo->nombre }}</td>
                    <td>{{ $espacio->localizacion->piso }}</td>
                    <td>{{ $espacio->aforo }} pax.</td>
                    <td>
                        <span class="badge {{ $espacio->estado->value === 'HABILITADO' ? 'bg-success' : 'bg-danger' }}">
                            {{ $espacio->estado->value }}
                        </span>
                    </td>
                    <td class="text-end">
                        <form action="{{ route('espacios.destroy', $espacio->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Seguro que deseas eliminar este espacio? Si tiene imagen, también se borrará.');">
                            <a href="{{ route('espacios.edit', $espacio->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
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
                <tr><td colspan="7" class="text-center text-muted py-4">No hay espacios registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $espacios->links() }}
        </div>

    </div>
</div>
@endsection
