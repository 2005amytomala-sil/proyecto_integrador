<nav class="navbar-dashboard d-flex align-items-center">
    <button class="btn btn-light me-3 d-flex align-items-center justify-content-center" id="btnSidebar" type="button">
        <i class="bi bi-list fs-4"></i>
    </button>

    <form class="d-flex me-auto" role="search">
        <input class="form-control me-2" type="search" placeholder="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>

    <a href="{{ route('notificaciones.index') }}" 
       class="btn btn-light me-3 position-relative p-2" 
       title="Notificaciones">
        <i class="bi bi-bell fs-5"></i>
        <span id="notif-badge" 
              class="position-absolute top-0 start-100 translate-middle bg-danger border border-light rounded-circle d-none" 
              style="width: 10px; height: 10px; padding: 0;">
        </span>
    </a>

    <div class="dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
            {{ auth()->user()->nombres }}
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