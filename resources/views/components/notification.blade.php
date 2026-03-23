{{-- resources/views/components/notification.blade.php --}}
@props([
    'title' => 'Notificación sin título',
    'description' => '',
    'img' => '',
    'id' => null
])
<div class="notification">
    <form method="POST" style="display:inline;">
        @csrf
        <button type="submit" formaction="{{ route('notification.view', ['id' => $id]) }}" class="notification-close-btn" style="background: none; border: none; cursor: pointer; padding: 0;">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
            </svg>
        </button>
    </form>
    <h6>{{ $title }}</h6>
    <hr/>
    <p>{{ $description }}</p>
    @if($img){
        <img src={{ $img }}/>
    }
    @endif
</div>
