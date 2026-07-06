<nav class="navbar-dashboard d-flex align-items-center">
    <button class="btn btn-light me-3 d-flex align-items-center justify-content-center" id="btnSidebar" type="button">
        <i class="bi bi-list fs-4"></i>
    </button>

    <form class="d-flex me-auto" role="search">
        <input class="form-control me-2" type="search" placeholder="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>

    <button type="button" class="btn btn-primary me-3">
        Notifications <span class="badge text-bg-secondary">4</span>
    </button>

    <div class="dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
            Admin
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Perfil</a></li>
            <li><a class="dropdown-item" href="#">Configuración</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">Cerrar sesión</button>
                </form>
            </li>
        </ul>
    </div>
</nav>