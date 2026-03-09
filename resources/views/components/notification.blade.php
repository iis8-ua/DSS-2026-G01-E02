{{-- resources/views/components/notification.blade.php --}}
@props([
    'title' => 'Notificación sin título',
    'description' => '',
    'img' => ''
])
<div class="notification">
    <button><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></button>
    <h6>{{ $title }}</h6>
    <hr/>
    <p>{{ $description }}</p>
    @if($img){
        <img src={{ $img }}/>
    }
    @endif
</div>
