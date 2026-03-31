@extends('layouts.master')
@section('title', 'Gestión de Reservas Grupales')
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
            <h1 class="h3 mb-0" style="color: #003366;">Gestión de Reservas Grupales</h1>
            <a href="{{ route('reservas-grupales.create') }}" class="btn text-white" style="background-color: #003366;">Añadir Nueva</a>
        </div>

        <form method="GET" action="{{ route('reservas-grupales.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control"
                       placeholder="Buscar por espacio o alumno...">
                <button type="submit" class="btn btn-dark">Buscar</button>
                <a href="{{ route('reservas-grupales.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                <tr>
                    <th>
                        <a href="{{ route('reservas-grupales.index', ['buscar' => request('buscar'), 'ordenar_por' => 'reserva_id', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            Reserva
                            @if(request('ordenar_por', 'reserva_id') == 'reserva_id')
                            <span>{{ request('direccion', 'desc') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>
                    <th>Espacio</th>
                    <th>Alumno titular</th>
                    <th>Inicio</th>
                    <th>
                        <a href="{{ route('reservas-grupales.index', ['buscar' => request('buscar'), 'ordenar_por' => 'aforo_max', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            Aforo máx.
                            @if(request('ordenar_por') == 'aforo_max')
                            <span>{{ request('direccion', 'desc') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>
                    <th>Miembros</th>
                    <th>Ocupación</th>
                    <th class="text-end" style="width: 150px;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($reservasGrupales as $rg)
                <tr>
                    <td class="fw-bold text-muted">{{ substr($rg->reserva_id, 0, 8) }}...</td>
                    <td>{{ $rg->reserva->espacio->nombre ?? '—' }}</td>
                    <td>{{ $rg->reserva->alumno->getFullName() ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($rg->reserva->hora_inicio)->format('d/m/Y H:i') }}</td>
                    <td>{{ $rg->aforo_max }}</td>
                    <td>
                        @if($rg->alumnos->count() > 0)
                        <div class="d-flex flex-wrap justify-content-center gap-1">
                            @foreach($rg->alumnos->take(3) as $alumno)
                            <span class="badge bg-primary">{{ $alumno->getFullName() }}</span>
                            @endforeach
                            @if($rg->alumnos->count() > 3)
                            <span class="badge bg-secondary">+{{ $rg->alumnos->count() - 3 }} más</span>
                            @endif
                        </div>
                        @else
                        <span class="badge bg-secondary">Sin miembros</span>
                        @endif
                    </td>
                    <td>
                        @php $ocupacion = $rg->alumnos->count(); $max = $rg->aforo_max; @endphp
                        @if($ocupacion >= $max)
                        <span class="badge bg-danger">Completo ({{ $ocupacion }}/{{ $max }})</span>
                        @elseif($max > 0 && $ocupacion >= $max * 0.75)
                        <span class="badge bg-warning text-dark">Casi lleno ({{ $ocupacion }}/{{ $max }})</span>
                        @else
                        <span class="badge bg-success">{{ $ocupacion }}/{{ $max }}</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <form action="{{ route('reservas-grupales.destroy', $rg) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Seguro que deseas eliminar esta reserva grupal? Se desvincularán todos los alumnos.');">

                            <a href="{{ route('reservas-grupales.show', $rg) }}" class="btn btn-sm btn-info text-white" title="Ver Detalles">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('reservas-grupales.edit', $rg) }}" class="btn btn-sm btn-outline-primary" title="Editar">
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
                <tr><td colspan="8" class="text-center text-muted py-4">No hay reservas grupales registradas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $reservasGrupales->links() }}
        </div>

    </div>
</div>
@endsection
