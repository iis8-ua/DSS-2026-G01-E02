{{-- resources/views/components/map.blade.php --}}
@php
    $ua_centerLat = 38.384;
    $ua_centerLng = -0.512;
    $ua_zoomLevel = 17;
@endphp


<div id="leaflet-map" class="h-full w-full" style="height: 100vh; z-index: 1"></div>
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    crossorigin=""
/>
<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    crossorigin=""
></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.leafletMap) { return; }

        const map = L.map('leaflet-map').setView(
            [{{ $ua_centerLat }}, {{ $ua_centerLng }}],
            {{ $ua_zoomLevel }}
        );

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 19,
        }).addTo(map);

        window.leafletMap = map;
    });
</script>