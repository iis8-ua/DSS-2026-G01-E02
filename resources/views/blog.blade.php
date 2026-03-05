{{-- resources/views/blog.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Blog de Incidencias</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="flex flex-col min-h-screen bg-gray-50 font-sans text-gray-800">

    {{-- Cabecera --}}
    <header class="bg-white border-b border-gray-200 shadow-sm px-8 py-5 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Incidencias Reportadas</h1>
            <p class="text-sm text-gray-500 mt-1">Supervisión del estado de las instalaciones</p>
        </div>
        <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full">Personal Docente</span>
    </header>

    <main class="flex-1 p-8 max-w-7xl mx-auto w-full">
        
        {{-- cuadrícula de incidencias --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($incidencias as $incidencia)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100 overflow-hidden flex flex-col">
                
                {{-- ponemos la foto si hay --}}
                @if ($incidencia->foto)
                    <img src="{{ asset('storage/' . $incidencia->foto) }}" alt="Foto de la incidencia" class="w-full h-48 object-cover border-b border-gray-100" />
                @else
                    <div class="w-full h-32 bg-gray-100 flex items-center justify-center border-b border-gray-100">
                        <span class="text-gray-400 text-sm italic flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Sin foto adjunta
                        </span>
                    </div>
                @endif

                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded">ID: {{ substr($incidencia->id, 0, 8) }}</span>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">
                            <!-- si la incidencia tiene reserva asociada, mostramos su horario -->
                            @if($incidencia->reserva)
                                {{ $incidencia->reserva->fecha_inicio?->format('H:i') }} - {{ $incidencia->reserva->fecha_fin?->format('H:i') }}
                                <!-- si no, no -->
                            @else
                                Sin horario
                            @endif
                            <!-- {{ $incidencia->reserva->horario()?->inicio?->format('H:i') }} - {{ $incidencia->reserva->horario()?->fin?->format('H:i') }} -->
                            <!-- {{ $incidencia->reserva->fecha_inicio?->format('H:i') }} - {{ $incidencia->reserva->fecha_fin?->format('H:i') }} -->
                        </span>
                    </div>

                    <p class="text-gray-700 text-sm mb-4 flex-1">
                        "{{ $incidencia->descripcion }}"
                    </p>

                    <div class="border-t border-gray-100 pt-4 mt-auto">
                        <div class="text-xs font-semibold text-gray-900 flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-xs font-bold">
                                <!-- {{ substr($incidencia->usuario->nombre, 0, 1) }} -->
                                
                                {{ strtoupper(substr($incidencia->usuario->nombre ?? 'U', 0, 1)) }}
                            </div>
                            {{ $incidencia->usuario->getFullName() ?? 'Usuario desconocido'}}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded shadow p-10 text-center text-gray-500 border border-gray-200 border-dashed">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                No hay incidencias reportadas en el sistema.
            </div>
            @endforelse
        </div>
    </main>
</body>
</html>