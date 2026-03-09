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
                    <a class="nav-link" href="{{ route('espacios.catalogo') }}">Catálogo de Espacios</a>
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
