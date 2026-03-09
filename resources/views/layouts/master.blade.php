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

@include('components.header')


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


@include('components.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>
