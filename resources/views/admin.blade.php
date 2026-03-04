{{-- resources/views/admin.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style></style>
    @endif
</head>
<body class="flex flex-col min-h-screen m-0 bg-gray-100">

    {{-- Cabecera --}}
    <header class="bg-white border-b border-gray-200 shadow-sm px-8 py-4 flex items-center justify-between">
        <h1 class="text-xl font-bold text-gray-800">Panel de Administración</h1>
        <span class="text-sm text-gray-500">Administrador</span>
    </header>

    <main class="flex-1 p-8 space-y-8">

        {{-- Gestionar Usuarios --}}
        <section class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Gestionar Usuarios</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 border-b text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">DNI</th>
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Rol</th>
                            <th class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuarios as $usuario)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $usuario->dni }}</td>
                            <td class="px-4 py-3">{{ $usuario->getFullName() }}</td>
                            <td class="px-4 py-3">{{ $usuario->email }}</td>
                            <td class="px-4 py-3 capitalize">{{ $usuario->tipo_usuario }}</td>
                            <td class="px-4 py-3 flex gap-2">
                                <button class="text-blue-600 hover:underline text-xs">Editar</button>
                                <button class="text-red-500 hover:underline text-xs">Eliminar</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-center text-gray-400">No hay usuarios registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Gestionar Espacios --}}
        <section class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Gestionar Espacios</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 border-b text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Tipo</th>
                            <th class="px-4 py-3">Aforo</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($espacios as $espacio)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $espacio->nombre }}</td>
                            <td class="px-4 py-3">{{ $espacio->tipo_espacio_id->nombre }}</td>
                            <td class="px-4 py-3">{{ $espacio->aforo }}</td>
                            <td class="px-4 py-3">
                                @if ($espacio->estado->value === 'HABILITADO')
                                    <span class="text-green-600 font-medium">Habilitado</span>
                                @else
                                    <span class="text-red-500 font-medium">Deshabilitado</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 flex gap-2">
                                <button class="text-blue-600 hover:underline text-xs">Editar</button>
                                <button class="text-red-500 hover:underline text-xs">Eliminar</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-400">No hay espacios definidos.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <button class="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700">
                    + Añadir espacio
                </button>
            </div>
        </section>

        {{-- Gestionar Reservas --}}
        <section class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Gestionar Reservas</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 border-b text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Alumno</th>
                            <th class="px-4 py-3">Espacio</th>
                            <th class="px-4 py-3">Inicio</th>
                            <th class="px-4 py-3">Fin</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reservas as $reserva)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $reserva->usuario->getFullName() }}</td>
                            <td class="px-4 py-3">{{ $reserva->espacio->nombre }}</td>
                            <td class="px-4 py-3">{{ $reserva->horario()?->inicio?->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">{{ $reserva->horario()?->fin?->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">{{ $reserva->estado->value }}</td>
                            <td class="px-4 py-3 flex gap-2">
                                <button class="text-red-500 hover:underline text-xs">Cancelar</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-400">No hay reservas registradas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </main>

</body>
</html>