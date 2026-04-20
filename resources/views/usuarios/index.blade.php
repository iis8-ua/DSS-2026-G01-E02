@extends('layouts.master')
@section('title', 'Gestión de Usuarios')
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
            <h1 class="h3 mb-0" style="color: #003366;">Gestión de Usuarios</h1>
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary" style="background-color: #003366; border-color: #003366;">Crear Nuevo</a>
        </div>

        {{-- Buscador --}}
        <form method="GET" action="{{ route('usuarios.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por nombre, DNI o email...">
                <button type="submit" class="btn btn-dark">Buscar</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>

        {{-- Tabla con ordenación --}}
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>
                        <a href="{{ route('usuarios.index', ['buscar' => request('buscar'), 'ordenar_por' => 'dni', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none text-dark d-flex justify-content-between">
                            DNI
                            <span>{{ request('ordenar_por') == 'dni' ? (request('direccion') == 'asc' ? '↓' : '↑') : '' }}</span>
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('usuarios.index', ['buscar' => request('buscar'), 'ordenar_por' => 'name', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none text-dark d-flex justify-content-between">
                            Nombre Completo
                            <span>{{ request('ordenar_por') == 'name' ? (request('direccion') == 'asc' ? '↓' : '↑') : '' }}</span>
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('usuarios.index', ['buscar' => request('buscar'), 'ordenar_por' => 'email', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none text-dark d-flex justify-content-between">
                            Email
                            <span>{{ request('ordenar_por') == 'email' ? (request('direccion') == 'asc' ? '↓' : '↑') : '' }}</span>
                        </a>
                    </th>
                    <th>Rol</th>
                    <th class="text-end" style="width: 200px;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($usuarios as $usuario)
                <tr>
                    <td class="fw-bold">{{ $usuario->dni }}</td>
                    <td>{{ $usuario->name }} {{ $usuario->apellidos }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        <span class="badge bg-info text-dark text-uppercase">
                            {{ strtolower($usuario->tipo_usuario) === 'gestor_espacios' ? 'gestor' : $usuario->tipo_usuario }}
                        </span>
                    </td>
                    <td class="text-end">
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Borrar">
                                <i class="bi bi-trash"></i> Borrar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hay usuarios definidos en el sistema.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $usuarios->links() }}
        </div>

    </div>
</div>
@endsection
