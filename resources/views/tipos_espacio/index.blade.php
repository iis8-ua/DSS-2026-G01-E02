@extends('layouts.master')

@section('title', 'Gestión de Tipos de Espacio')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="bg-white p-5 rounded shadow-sm">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0" style="color: #003366;">Gestión de Tipos de Espacio</h1>
            <a href="{{ route('tipos-espacio.create') }}" class="btn btn-primary" style="background-color: #003366; border-color: #003366;">Crear Nuevo</a>
        </div>

        {{-- esta es la parte del buscador --}}
        <form method="GET" action="{{ route('tipos-espacio.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por nombre...">
                <button type="submit" class="btn btn-dark">Buscar</button>
                <a href="{{ route('tipos-espacio.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>

        {{-- parte de la ordenación--}}
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>
                        <a href="{{ route('tipos-espacio.index', ['buscar' => request('buscar'), 'ordenar_por' => 'nombre', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none text-dark d-flex justify-content-between">
                            Nombre
                            <span>{{ request('direccion') == 'asc' ? '↓' : '↑' }}</span>
                        </a>
                    </th>
                    <th class="text-end" style="width: 200px;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->nombre }}</td>
                    <td class="text-end">
                        <form action="{{ route('tipos-espacio.destroy', $tipo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este tipo de espacio?');">
                            <a href="{{ route('tipos-espacio.edit', $tipo->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
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
                <tr><td colspan="2" class="text-center text-muted py-4">No hay tipos de espacio definidos en el sistema.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{--parte de la paginacion--}}
        <div class="d-flex justify-content-center mt-4">
            {{ $tipos->links() }}
        </div>

    </div>
</div>
@endsection
