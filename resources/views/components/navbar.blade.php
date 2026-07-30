<nav class="navbar-dashboard d-flex align-items-center">

    <button class="btn btn-light me-3 d-flex align-items-center justify-content-center" id="btnSidebar" type="button">
        <i class="bi bi-list fs-4"></i>
    </button>

    <div class="ms-auto d-flex align-items-center">
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
                <li>
                    <a class="dropdown-item" href="{{ route('perfil.mio')}}">
                        <i class="bi bi-person me-2"></i>Perfil
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="{{ route('configuracion.index')}}">
                        <i class="bi bi-gear"></i> Configuración
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item bi-box-arrow-right" type="submit">
                            Cerrar sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

</nav>