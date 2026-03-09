{{-- resources/views/components/history.blade.php --}}
{{--
    Uso:
    <x-history :reservas="$reservas" />

    Representa un conjunto de objetos Reserva
--}}
<div
    id="history-sidebar"
    class="inset-y-0 left-0 border-r border-gray-200 shadow-lg overflow-y-auto h-full absolute p-8"
    style="width: 320px; z-index: 1000; background-color: white;"
>
    <div class="p-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Mis reservas</h2>
    </div>

    <div class="p-4 space-y-4">
        {{-- lista de reservas --}}
        @forelse ($reservas as $reserva)

        {{-- Color del borde según estado de reserva --}}
        @php
            $estadoLower = strtolower($reserva->estado->value);
            $borderColor = match($estadoLower){
                'pendiente'  => 'border-yellow-400',
                'aceptada'   => 'border-green-400',
                'rechazada'  => 'border-red-400',
                'cancelada'  => 'border-gray-400',
                'finalizada' => 'border-blue-400',
                default      => 'border-gray-200',
            };
        @endphp

        <div class="border-l-4 {{ $borderColor }} bg-gray-50 rounded p-3 shadow-sm">
            {{-- ESPACIO Reservado--}}
            <p class="text-sm font-semibold text-gray-800">
                {{ $reserva->espacio->nombre }}
            </p>
            {{-- HORARIO Reservado --}}
            <p class="text-xs text-gray-500 mt-1">
                <!-- {{ $reserva->horario()?->inicio?->format('d/m/Y H:i') }} &mdash; {{ $reserva->horario()?->fin?->format('d/m/Y H:i') }} -->
                {{ $reserva->fecha_inicio?->format('d/m/Y H:i') }} &mdash; {{ $reserva->fecha_fin?->format('d/m/Y H:i') }}
            </p>
            {{-- etiquetas del estado de la reserva --}}
            <span class="inline-block mt-2 text-xs font-medium px-2 py-0.5 rounded-full
                @if($estadoLower === 'pendiente')  bg-yellow-100 text-yellow-700 @endif
                @if($estadoLower === 'aceptada')   bg-green-100  text-green-700  @endif
                @if($estadoLower === 'rechazada')  bg-red-100    text-red-700    @endif
                @if($estadoLower === 'cancelada')  bg-gray-100   text-gray-600   @endif
                @if($estadoLower === 'finalizada') bg-blue-100   text-blue-700   @endif
            ">
                {{ ucfirst($estadoLower) }}
            </span>
        </div>

        @empty
        <p class="text-sm text-gray-400 text-center">No tienes reservas todavía.</p>
        @endforelse
    </div>
</div>