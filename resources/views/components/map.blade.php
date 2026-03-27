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
    const localizaciones = @json($markers);
</script>
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
        const customIcon = L.icon({
            iconUrl: '/images/marker-icon.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
        });

        localizaciones.forEach(loc => {
            if (loc.latitud && loc.longitud) {
                const marker = L.marker([loc.latitud, loc.longitud]).addTo(map);
                    marker.bindPopup(`
                    <strong>${loc.nombre}</strong><br />
                    <a href="/reservas/nueva/${loc.id}">
                        Reservar
                    </a>
                `);
            }
        });
    });
</script>
