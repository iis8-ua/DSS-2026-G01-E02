{{-- resources/views/admin.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script> {{-- Fallback por si falla Vite --}}
    @endif
    <style>
        /* ajuste para los iconos de ordenación */
        th.sortable:hover { background-color: #e5e7eb; cursor: pointer; }
        .asc svg { transform: rotate(180deg); }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-50 text-gray-800 font-sans">

    {{-- Cabecera --}}
    <header class="bg-white border-b border-gray-200 shadow-sm px-8 py-5 flex items-center justify-between sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <div class="bg-blue-600 w-8 h-8 rounded flex items-center justify-center text-white font-bold">A</div>
            <h1 class="text-2xl font-bold text-gray-800">Panel de Administración</h1>
        </div>
        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">Administrador</span>
    </header>

    <main class="flex-1 p-8 space-y-10 max-w-7xl mx-auto w-full">

        {{-- Gestionar Usuarios --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Gestionar Usuarios</h2>
            {{-- contenedor con scroll --}}
            <div class="overflow-y-auto overflow-x-auto max-h-[400px] rounded-lg border border-gray-200 shadow-inner">
                <table class="w-full text-sm text-left text-gray-600">
                    {{-- Cabecera que se mantiene siempre --}}
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th class="px-6 py-4 sortable" onclick="sortTable(this, 0)">DNI <span>↕</span></th>
                            <th class="px-6 py-4 sortable" onclick="sortTable(this, 1)">Nombre <span>↕</span></th>
                            <th class="px-6 py-4 sortable" onclick="sortTable(this, 2)">Email <span>↕</span></th>
                            <th class="px-6 py-4 sortable" onclick="sortTable(this, 3)">Rol <span>↕</span></th>
                            <th class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($usuarios as $usuario)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $usuario->dni }}</td>
                            <td class="px-6 py-4">{{ $usuario->getFullName() }}</td>
                            <td class="px-6 py-4">{{ $usuario->email }}</td>
                            <td class="px-6 py-4 capitalize">
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium">{{ $usuario->tipo_usuario }}</span>
                            </td>
                            <td class="px-6 py-4 flex gap-3 justify-end">
                                <button class="text-blue-600 hover:text-blue-800 font-medium transition">Editar</button>
                                <button class="text-red-600 hover:text-red-800 font-medium transition">Eliminar</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 no-sort">No hay usuarios registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Gestionar Espacios --}}
        <!-- ponemos el mismo formato de contenedor -->
        <section class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Gestionar Espacios</h2>
                <a href="{{ route('espacios.create') }}" class="bg-blue-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-blue-700 shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Añadir espacio
                </a>
            </div>
            <div class="overflow-y-auto overflow-x-auto max-h-[400px] rounded-lg border border-gray-200 shadow-inner">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th class="px-6 py-4 sortable" onclick="sortTable(this, 0)">Nombre <span>↕</span></th>
                            <th class="px-6 py-4 sortable" onclick="sortTable(this, 1)">Tipo <span>↕</span></th>
                            <th class="px-6 py-4 sortable" onclick="sortTable(this, 2)">Aforo <span>↕</span></th>
                            <th class="px-6 py-4 sortable" onclick="sortTable(this, 3)">Estado <span>↕</span></th>
                            <th class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($espacios as $espacio)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $espacio->nombre }}</td>
                            <td class="px-6 py-4">{{ $espacio->tipo->nombre }}</td>
                            <td class="px-6 py-4" data-value="{{ $espacio->aforo }}">{{ $espacio->aforo }} pers.</td>
                            <td class="px-6 py-4">
                                @if ($espacio->estado->value === 'HABILITADO')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Habilitado</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Deshabilitado</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 flex gap-3 justify-end">
                                <button class="text-blue-600 hover:text-blue-800 font-medium transition">Editar</button>
                                <button class="text-red-600 hover:text-red-800 font-medium transition">Eliminar</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 no-sort">No hay espacios definidos.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
        
        {{-- Gestionar Reservas --}}
        <!-- mismo formato de contenedor con scroll -->
        <section class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Gestionar Reservas</h2>
                <a href="{{ route('reservas.create') }}" class="bg-blue-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-blue-700 shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Añadir reserva
                </a>
            </div>
            <div class="overflow-y-auto overflow-x-auto max-h-[400px] rounded-lg border border-gray-200 shadow-inner">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th class="px-6 py-4 sortable" onclick="sortTable(this, 0)">Alumno <span>↕</span></th>
                            <th class="px-6 py-4 sortable" onclick="sortTable(this, 1)">Espacio <span>↕</span></th>
                            <th class="px-6 py-4 sortable" onclick="sortTable(this, 2)">Inicio <span>↕</span></th>
                            <th class="px-6 py-4 sortable" onclick="sortTable(this, 3)">Fin <span>↕</span></th>
                            <th class="px-6 py-4 sortable" onclick="sortTable(this, 4)">Estado <span>↕</span></th>
                            <th class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($reservas as $reserva)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $reserva->user->getFullName() }}</td>
                            <td class="px-6 py-4">{{ $reserva->espacio->nombre }}</td>
                            <!-- <td class="px-6 py-4">{{ $reserva->horario()?->inicio?->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">{{ $reserva->horario()?->fin?->format('d/m/Y H:i') }}</td> -->
                            <td class="px-6 py-4">{{ $reserva->fecha_inicio?->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">{{ $reserva->fecha_fin?->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">
                                {{-- etiquetas dinámicas según el enum de la reserva --}}
                                @switch($reserva->estado->value)
                                    @case('pendiente')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pendiente</span>
                                        @break
                                    @case('aceptada')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aceptada</span>
                                        @break
                                    @case('rechazada')
                                    @case('cancelada')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ ucfirst($reserva->estado->value) }}</span>
                                        @break
                                    @case('finalizada')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Finalizada</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 flex gap-3 justify-end">
                                <button class="text-blue-600 hover:text-blue-800 font-medium transition">Editar</button>
                                <button class="text-red-600 hover:text-red-800 font-medium transition">Eliminar</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400 no-sort">No hay reservas definidas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    
    {{-- script para ordenar las tablas --}}
    <script>
        function sortTable(headerElement, columnIndex) {
            const table = headerElement.closest('table');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            // si la tabla está vacía --> ignoramos
            if (rows.length === 1 && rows[0].querySelector('.no-sort')){
                return;
            }

            // obtenemos la dirección a ordenar
            const isAscending = headerElement.classList.contains('asc');
            const direction = isAscending ? -1 : 1;

            // reseteamos las flechas de ordenación del resto de cabeceras
            table.querySelectorAll('th').forEach(th => th.classList.remove('asc', 'desc'));
            headerElement.classList.add(isAscending ? 'desc' : 'asc');

            // ordenamos las filas
            rows.sort((a, b) => {
                const aCol = a.querySelectorAll('td')[columnIndex];
                const bCol = b.querySelectorAll('td')[columnIndex];

                // extraemos el texto o nos quedamos con el data-value para los números
                const aText = aCol.getAttribute('data-value') || aCol.innerText.trim();
                const bText = bCol.getAttribute('data-value') || bCol.innerText.trim();

                // Intentamos ordenar numéricamente primero y, si no, alfabéticamente
                const aNum = parseFloat(aText);
                const bNum = parseFloat(bText);

                if (!isNaN(aNum) && !isNaN(bNum)) {
                    return (aNum - bNum) * direction;
                }

                return aText.localeCompare(bText) * direction;
            });

            // volvemos a añadir las filas a la tabla en el nuevo orden
            rows.forEach(row => tbody.appendChild(row));
        }
    </script>
</body>
</html>