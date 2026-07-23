<nav class="nav flex-column mt-4">
    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i class="bi bi-grid"></i> Panel de Control
    </a>

    <a class="nav-link {{ request()->routeIs('incidencias.*') ? 'active' : '' }}" href="{{ route('incidencias.index') }}">
        <i class="bi bi-exclamation-circle"></i> Incidencias
    </a>

    <a class="nav-link {{ request()->routeIs('incidencias.mias') ? 'active' : '' }}" href="{{ route('incidencias.mias')}}">
        <i class="bi bi-list-check"></i> Mis incidencias
    </a>
    
    <a class="nav-link" href="#">
        <i class="bi bi-check-circle"></i> Validar Incidencias
    </a>

    <a class="nav-link" href="#">
        <i class="bi bi-person-check"></i> Asignar Responsables
    </a>

    <a class="nav-link" href="#">
        <i class="bi bi-geo-alt"></i> Ubicaciones
    </a>

    <a class="nav-link" href="#">
        <i class="bi bi-bell"></i> Notificaciones
    </a>
</nav>