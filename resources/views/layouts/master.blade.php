<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reserva de Espacios - Universidad de Alicante')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    
    {{-- -
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    --}}
    <style>
        .navbar-ua {
            background-color: #003366; 
            position: sticky;
            top: 0 !important;
        }
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

        body {
            overflow-x: hidden;
            overflow-y: auto;
            max-width: 100vw;
        }

        /*
            SIDEBAR DE NOTIFICACIONES
        */
        aside {
            padding: 20px;
            background-color: white;
            position: absolute;
            height: 100%;
            right: 0;
            z-index: 1000;
            box-shadow: -5px 0px 20px rgba(0,0,0, 0.2);
            transition: all 1s ease-in-out;
            transform: translateX(0);

            & #aside_close {
                position: absolute;
                left: -50px;
                width: 50px;
                height: 50px;
                border: none;
                outline: none;
                top: 10px;
                background-color: white;
                border-radius: 5px 0 0 5px;
                box-shadow: -10px 0px 20px rgba(0,0,0, 0.2);
                z-index: 999;
            }

            & svg {
                transition: all 1s ease-in-out;
            }
        }

        /*
            SIDEBAR CERRADA
        */
        .closed {
            transform: translateX(300px);

            & svg {
                transform:rotateY(180deg);
            }
        }

        /*
            NOTIFICACIONES
        */
        .notification {
            border: 1px solid #888888aa;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;

            & button {
                position: absolute;
                right: 15%;
                background-color: #e6624bff;
                border: none;
                outline: none;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                text-align: center;
                cursor: pointer;
                padding: 2px;
                margin: auto;
                display: inline-flex;
                justify-content: center;
                align-items: center;

                & svg {
                    opacity: 1 !important;
                    width: 100% !important;
                    height: 100% !important;
                }
            }
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
<script>
    /**
     * SIDEBAR DE NOTIFICACIONES
     */
    let aside_open = false;
    const button = document.getElementById("aside_close");
    const aside = document.getElementById("notifications-sidebar");
    button.addEventListener("click", () => {
        if(aside_open){
            aside.classList.add("closed");
            aside_open = false;
        }
        else {
            aside.classList.remove("closed");
            aside_open = true;

        }
    })

    /**
     * BOTÓN DE CIERRE DE NOTIFICACIÓN
     */
    const notifications = document.getElementsByClassName("notification");
    Array.from(notifications).forEach(n => {
        let button = n.querySelector("button");
        button.addEventListener("click", () => {
            n.remove();
        })
    });
</script>

@yield('scripts')

</body>
</html>
