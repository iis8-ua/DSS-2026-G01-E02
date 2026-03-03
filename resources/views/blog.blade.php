{{-- resources/views/blog.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Incidencias</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style></style>
    @endif
</head>
<body class="flex flex-col min-h-screen m-0 bg-gray-100">

    {{-- Cabecera --}}
    <header class="bg-white border-b border-gray-200 shadow-sm px-8 py-4 flex items-center justify-between">
        <h1 class="text-xl font-bold text-gray-800">Incidencias reportadas</h1>
        <span class="text-sm text-gray-500">Personal docente</span>
    </header>

    <main class="flex-1 p-8">

        {{-- lista de incidencias --}}
        @forelse ($incidencias as $incidencia)
        <div class="bg-white rounded shadow p-6 mb-4 border-l-4 border-blue-400">

            <div class="flex items-start justify-between mb-2">
                <div>
                    <p class="text-sm font-semibold text-gray-800">
                        {{ $incidencia->usuario->getFullName() }}
                    </p>
                    <p class="text-xs text-gray-400">
                        <!-- Espacio: {{ $incidencia->reserva->espacio->nombre }} -->
                        &mdash;
                        {{ $incidencia->reserva->horario()?->inicio?->format('H:i') }} / {{ $incidencia->reserva->horario()?->fin?->format('H:i') }}
                    </p>
                </div>
                <span class="text-xs text-gray-400">ID: {{ $incidencia->id }}</span>
            </div>

            <p class="text-sm text-gray-700 mb-3">{{ $incidencia->descripcion }}</p>

            @if ($incidencia->foto)
                <img
                    src="{{ asset('storage/' . $incidencia->foto) }}"
                    alt="Foto de la incidencia"
                    class="rounded border border-gray-200 max-h-48 object-cover"
                />
            @else
                <p class="text-xs text-gray-400 italic">Sin foto adjunta.</p>
            @endif

        </div>
        @empty
        <div class="bg-white rounded shadow p-6 text-center text-gray-400">
            No hay incidencias reportadas.
        </div>
        @endforelse

    </main>

</body>
</html>