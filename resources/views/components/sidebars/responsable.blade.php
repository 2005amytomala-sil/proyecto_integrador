<nav class="nav flex-column mt-4">
    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i class="bi bi-grid"></i> Panel de Control
    </a>

    <a class="nav-link {{ request()->routeIs('incidencias.*') ? 'active' : '' }}" href="{{ route('incidencias.index') }}">
        <i class="bi bi-tools"></i>Mis Incidencias
    </a>

    <a class="nav-link" href="#">
        <i class="bi bi-chat-dots"></i> Comentarios
    </a>

    <a class="nav-link" href="#">
        <i class="bi bi-upload"></i> Evidencias
    </a>

    <a class="nav-link" href="#">
        <i class="bi bi-bell"></i> Notificaciones
    </a>
</nav>