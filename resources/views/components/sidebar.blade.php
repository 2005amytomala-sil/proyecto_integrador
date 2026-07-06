<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand text-center">
        <strong>Sistema de Gestión de Incidencias</strong>
    </div>

    <nav class="nav flex-column mt-4">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-grid"></i> Panel de Control
        </a>

        <a class="nav-link {{ request()->routeIs('incidencias.*') ? 'active' : '' }}" href="{{ route('incidencias.index') }}">
            <i class="bi bi-exclamation-circle"></i> Incidencias
        </a>

        <a class="nav-link" href="#">
            <i class="bi bi-calendar-check"></i> Asignaciones
        </a>

        <a class="nav-link" href="#">
            <i class="bi bi-people"></i> Usuarios
        </a>

        <a class="nav-link" href="#">
            <i class="bi bi-tags"></i> Categorías
        </a>

        <a class="nav-link" href="#">
            <i class="bi bi-geo-alt"></i> Ubicaciones
        </a>

        <a class="nav-link" href="#">
            <i class="bi bi-bar-chart"></i> Informes
        </a>

        <a class="nav-link" href="#">
            <i class="bi bi-bell"></i> Notificaciones
        </a>
    </nav>
</aside>