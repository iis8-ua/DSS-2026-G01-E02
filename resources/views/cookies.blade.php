@extends('layouts.master')

@section('title', 'Política de Cookies - EspaciUA')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm border-0">
        <div class="card-header text-white" style="background-color: #003366;">
            <h1 class="h4 mb-0"><i class="bi bi-cookie"></i> Política de Cookies</h1>
        </div>
        <div class="card-body p-4">
            <h5 class="text-primary mt-3">¿Qué son las cookies?</h5>
            <p>Una cookie es un fichero que se descarga en su ordenador al acceder a determinadas páginas web. Permiten almacenar y recuperar información sobre los hábitos de navegación de un usuario o de su equipo.</p>

            <h5 class="text-primary mt-4">Cookies utilizadas en esta plataforma</h5>
            <p>"EspaciUA" utiliza <strong>exclusivamente cookies técnicas y de sesión</strong>, las cuales son estrictamente necesarias para el funcionamiento de la aplicación.</p>
            <ul>
                <li><strong>Cookies de sesión (<code>laravel_session</code>):</strong> Permiten mantener al usuario autenticado mientras navega por el catálogo de espacios y realiza sus reservas. Desaparecen al cerrar el navegador o cerrar sesión.</li>
                <li><strong>Cookies de seguridad (<code>XSRF-TOKEN</code>):</strong> Evitan ataques de falsificación de peticiones en sitios cruzados (CSRF), garantizando que los formularios de reserva y login se envían de forma segura.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
