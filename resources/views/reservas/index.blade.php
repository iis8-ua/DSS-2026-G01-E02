@extends('layouts.master')

@section('title', 'Gestión de Reservas')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="bg-white p-5 rounded shadow-sm">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0" style="color: #003366;">Gestión de Reservas</h1>
            <a href="{{ route('reservas.create') }}" class="btn text-white" style="background-color: #003366;">Añadir Nueva</a>
        </div>

        {{-- Parte del buscador --}}
        <form method="GET" action="{{ route('reservas.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por alumno, espacio o estado...">
                <button type="submit" class="btn btn-dark">Buscar</button>
                <a href="{{ route('reservas.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                <tr>
                    <th>Imagen</th>
                    <th>
                        <a href="{{ route('reservas.index', ['buscar' => request('buscar'), 'ordenar_por' => 'alumno', 'direccion' => request('direccion') == 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none text-dark d-flex justify-content-center align-items-center gap-2">
                            Usuario
                            @if(request('ordenar_por') == 'alumno')
                            <span>{{ request('direccion', 'asc') == 'asc' ? '↓' : '↑' }}</span>
                            @endif
                        </a>
                    </th>
                    <th>Espacio</th>
                    <th>Horario</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th class="text-end" style="width: 150px;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($reservas as $reserva)
                <tr>
                    {{-- Imagen del espacio --}}
                    <td>
                        @if($reserva->espacio && $reserva->espacio->imagen)
                        <img src="{{ asset('images/espacios/' . $reserva->espacio->imagen) }}" alt="{{ $reserva->espacio->nombre }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;" class="shadow-sm">
                        @else
                        <span class="badge bg-secondary">Sin imagen</span>
                        @endif
                    </td>
                    
                    {{-- Usuario y espacio --}}
                    <td class="fw-bold">{{ $reserva->alumno->getFullName() ?? 'Usuario Desconocido' }}</td>
                    <td>{{ $reserva->espacio->nombre ?? 'Espacio Eliminado' }}</td>
                    
                    {{-- Fechas --}}
                    <td class="small">
                        {{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('d/m/Y H:i') }}<br>
                        a<br>
                        {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('d/m/Y H:i') }}
                    </td>

                    {{-- Tipo de Reserva --}}
                    <td>
                        @if($reserva->reservaGrupal)
                            <span class="badge bg-info text-dark"><i class="bi bi-people-fill me-1"></i> Grupal</span>
                        @else
                            <span class="badge bg-light text-dark border"><i class="bi bi-person-fill me-1"></i> Individual</span>
                        @endif
                    </td>

                    {{-- Estado de la reserva --}}
                    <td>
                        @php
                            // obtenemos el color según el estado
                            $estadoValor = $reserva->estado->value ?? $reserva->estado;
                            $colorBadge = match($estadoValor) {
                                'ACEPTADA', 'APROBADA' => 'bg-success',
                                'CANCELADA', 'RECHAZADA' => 'bg-danger',
                                'PENDIENTE' => 'bg-warning text-dark',
                                default => 'bg-secondary',
                            };
                        @endphp
                        <span class="badge {{ $colorBadge }}">
                            {{ $reserva->estado }}
                        </span>
                    </td>

                    {{-- Acciones --}}
                    <td class="text-end">
                        <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar esta reserva del sistema?');">
                            {{-- Ver la reserva --}}
                            <a href="{{ route('reservas.show', $reserva->id) }}" class="btn btn-sm btn-info text-white" title="Ver Detalles">
                                <i class="bi bi-eye"></i>
                            </a>

                            {{-- Editar --}}
                            <a href="{{ route('reservas.edit', $reserva->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            
                            @csrf
                            @method('DELETE')
                            {{-- Eliminar --}}
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Borrar">
                                <i class="bi bi-trash"></i>
                            </button>

                            
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No hay reservas registradas en el sistema.</td></tr>
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