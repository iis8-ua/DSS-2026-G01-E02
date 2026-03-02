{{-- resources/views/components/notifications.blade.php --}}
@php
    $sidebarWidth = '300px';
@endphp
<sidebar
    id="notifications-sidebar"
    class="inset-y-0 right-0 border-l border-gray-200 shadow-lg overflow-y-auto w-300 h-full absolute p-8" 
    style="width: {{ $sidebarWidth }}; z-index: 1000; background-color:white;"
>
    <div class="p-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">
            Notificaciones
        </h2>
    </div>
    <div class="p-4 space-y-4">

    <x-notification >
        <strong>Hola mundo!</strong>
    </x-notification>   
    
    </div>
</sidebar>