@extends('layouts.master')

@section('title', 'Gestión de Incidencias')

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
                @if(Auth::user()->tipo_usuario == "admin")
                <a href="{{ route('admin.index') }}" class="btn btn-volver rounded-pill text-decoration-none mb-4 py-2 px-3 d-inline-flex align-items-center shadow-sm">
                    <i class="bi bi-arrow-left fs-6 me-2"></i>
                    <span style="font-size: 0.9rem;">Volver al panel</span>
                </a>
                @endif
            @if(Auth::user()->tipo_usuario == "admin")
            <h1 class="h3 mb-0" style="color: #003366;">Gestión de Incidencias</h1>
            @endif

            @if(Auth::user()->tipo_usuario != "admin")
            <h1 class="h3 mb-0" style="color: #003366;">Blog de Incidencias</h1>
            @endif
            <a href="{{ route('incidencias.create') }}" class="btn text-white" style="background-color: #003366;">Añadir Nueva</a>
        </div>

        <form method="GET" action="{{ route('incidencias.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por descripción o usuario...">
                <button type="submit" class="btn btn-dark">Buscar</button>
                <a href="{{ route('incidencias.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                <tr>
                    <th>Foto</th>
                    <th>
                        <a href="{{ route('incidencias.index', ['buscar' => request('buscar'), 'ordenar_por' => 'id', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            ID
                            @if(request('ordenar_por', 'id') == 'id')
                            <span>{{ request('direccion', 'desc') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>
                    <th class="text-start">Descripción</th>
                    <th>
                        <a href="{{ route('incidencias.index', ['buscar' => request('buscar'), 'ordenar_por' => 'usuario', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            Usuario
                            @if(request('ordenar_por') == 'usuario')
                            <span>{{ request('direccion', 'desc') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>
                    {{--
                        Esta acción será de administrador: lo dejamos como gestor de espacios temporalmente
                        hasta que tengamos la autenticación de administrador terminada, para poder hacer
                        demostraciones técnicas.
                    --}}
                    @if(Auth::user()->tipo_usuario == "admin")
                    <th class="text-end" style="width: 150px;">Acciones</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @forelse($incidencias as $incidencia)
                <tr>
                    <td>
                        @if($incidencia->foto)
                        <img src="{{ asset('images/incidencias/' . $incidencia->foto) }}"
                             alt="Foto incidencia"
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"
                             class="shadow-sm">
                        @else
                        <span class="badge bg-secondary">Sin foto</span>
                        @endif
                    </td>
                    <td class="fw-bold text-muted">{{ substr($incidencia->id, 0, 8) }}...</td>
                    <td class="text-start text-truncate" style="max-width: 250px;" title="{{ $incidencia->descripcion }}">
                        {{ $incidencia->descripcion }}
                    </td>
                    <td>{{ $incidencia->usuario->getFullName() ?? 'Usuario Desconocido' }}</td>

                    {{--
                        Esta acción será de administrador: lo dejamos como gestor de espacios temporalmente
                        hasta que tengamos la autenticación de administrador terminada, para poder hacer
                        demostraciones técnicas.
                    --}}
                    @if(Auth::user()->tipo_usuario == "admin")
                    <td class="text-end">
                        <form action="{{ route('incidencias.destroy', $incidencia->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Seguro que deseas eliminar esta incidencia? Si tiene foto, también se borrará.');">

                            <a href="{{ route('incidencias.show', $incidencia->id) }}" class="btn btn-sm btn-info text-white" title="Ver Detalles">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('incidencias.edit', $incidencia->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Borrar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hay incidencias registradas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $incidencias->links() }}
        </div>

    </div>
</div>
@endsection
