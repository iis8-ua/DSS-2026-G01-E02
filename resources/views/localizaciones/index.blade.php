@extends('layouts.master')

@section('title', 'Gestión de Localizaciones')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="bg-white p-5 rounded shadow-sm">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0" style="color: #003366;">Gestión de Localizaciones</h1>
            <a href="{{ route('localizaciones.create') }}" class="btn text-white" style="background-color: #003366;">Añadir Nueva</a>
        </div>

        {{--parte del buscador--}}
        <form method="GET" action="{{ route('localizaciones.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por piso, latitud o longitud...">
                <button type="submit" class="btn btn-dark">Buscar</button>
                <a href="{{ route('localizaciones.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                <tr>
                    {{--latitud--}}
                    <th>
                        <a href="{{ route('localizaciones.index', [
                                'buscar' => request('buscar'),
                                'ordenar_por' => 'latitud',
                                'direccion' => (request('ordenar_por') == 'latitud' && request('direccion') == 'asc') ? 'desc' : 'asc'
                            ]) }}" class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            Latitud
                            @if(request('ordenar_por') == 'latitud')
                            <span>{{ request('direccion') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>

                    {{--longitud--}}
                    <th>
                        <a href="{{ route('localizaciones.index', [
                                'buscar' => request('buscar'),
                                'ordenar_por' => 'longitud',
                                'direccion' => (request('ordenar_por') == 'longitud' && request('direccion') == 'asc') ? 'desc' : 'asc'
                            ]) }}" class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            Longitud
                            @if(request('ordenar_por') == 'longitud')
                            <span>{{ request('direccion') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>

                    {{--piso--}}
                    <th>
                        <a href="{{ route('localizaciones.index', [
                                'buscar' => request('buscar'),
                                'ordenar_por' => 'piso',
                                'direccion' => (request('ordenar_por', 'piso') == 'piso' && request('direccion') == 'asc') ? 'desc' : 'asc'
                            ]) }}" class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            Piso
                            @if(request('ordenar_por', 'piso') == 'piso')
                            <span>{{ request('direccion', 'asc') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>

                    <th class="text-end" style="width: 200px;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($localizaciones as $loc)
                <tr>
                    <td>{{ $loc->latitud }}</td>
                    <td>{{ $loc->longitud }}</td>
                    <td>{{ $loc->piso }}</td>
                    <td class="text-end">
                        <form action="{{ route('localizaciones.destroy', $loc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar esta localización?');">
                            <a href="{{ route('localizaciones.edit', $loc->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
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
                <tr><td colspan="4" class="text-center text-muted py-4">No hay localizaciones definidas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $localizaciones->links() }}
        </div>

    </div>
</div>
@endsection
