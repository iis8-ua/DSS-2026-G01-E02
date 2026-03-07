<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reserva de Espacios - Universidad de Alicante')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        .navbar-ua { background-color: #003366; }
        .navbar-ua .navbar-brand, .navbar-ua .nav-link { color: #ffffff; }
        .navbar-ua .nav-link:hover { color: #cccccc; }
        .footer-ua {
            background-color: #f8f9fa;
            border-top: 4px solid #003366;
        }
        .hover-blue:hover {
            color: #003366 !important;
            text-decoration: underline !important;
        }
    </style>

    @yield('css')
</head>

<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-ua shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
            <img src="{{ asset('images/logo-ua.png') }}" alt="Logo UA" height="40" class="me-2">
            EspaciUA
        </a>

        <button class="navbar-toggler border-white" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion">
            <i class="bi bi-list text-white fs-2"></i>
        </button>

        <div class="collapse navbar-collapse" id="menuNavegacion">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Catálogo de Espacios</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="#">Mis Reservas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Incidencias</a>
                </li>
                @endauth
            </ul>

            <ul class="navbar-nav">
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="#">Iniciar Sesión</a>
                </li>
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarUser" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Mi Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="#" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="flex-grow-1 container py-4">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @yield('content')

</main>

<footer class="footer-ua text-center py-4 mt-auto">
    <div class="container text-muted">

        <div class="mb-3 d-flex justify-content-center flex-wrap gap-4">
            <a href="{{ route('legal.aviso') }}" class="text-decoration-none text-dark hover-blue">Aviso Legal</a>
            <a href="{{ route('legal.privacidad') }}" class="text-decoration-none text-dark hover-blue">Protección de Datos</a>
            <a href="{{ route('legal.accesibilidad') }}" class="text-decoration-none text-dark hover-blue">Accesibilidad</a>
            <a href="{{ route('legal.cookies') }}" class="text-decoration-none text-dark hover-blue">Cookies</a>
        </div>

        <small>
            &copy; {{ date('Y') }} Universidad de Alicante - Sistema de Reserva de Espacios.<br>
        </small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>
