{{-- resources/views/components/notifications.blade.php --}}
@php
    $sidebarWidth = '300px';
@endphp

<aside id="notifications-sidebar" style="width: {{ $sidebarWidth }}" class="closed">
    <h2>Notificaciones</h2>
    <hr/>
    <div id="notifications_container">
        @foreach($notifications as $notif)
            <x-notification 
                :title="$notif->titulo"
                :description="$notif->texto" 
                :img="$notif->imagen"
                :id="$notif->id"
            />
        @endforeach
    </div>
    <button id="aside_close" >
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#888"><path d="M383-480 200-664l56-56 240 240-240 240-56-56 183-184Zm264 0L464-664l56-56 240 240-240 240-56-56 183-184Z"/></svg>
    </button>
        <form method="POST" style="display:inline;">
            @csrf
                <button type="submit" formaction="{{route('notification.viewall')}}" id="notif-close-all" >
                    Marcar todas como leídas
                </button>
        </form>
</aside>