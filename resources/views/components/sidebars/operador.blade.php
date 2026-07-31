<nav class="nav flex-column mt-4">
    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i class="bi bi-grid"></i> Panel de Control
    </a>

    <a class="nav-link {{ request()->routeIs('incidencias.index') ? 'active' : '' }}"
       href="{{ route('incidencias.index') }}">
        <i class="bi bi-exclamation-circle"></i> Incidencias
    </a>

    <a class="nav-link {{ request()->routeIs('asignaciones.*') ? 'active' : '' }}"
       href="{{ route('asignaciones.index') }}">
        <i class="bi bi-calendar-check"></i> Asignaciones
    </a>

    <a class="nav-link {{ request()->routeIs('notificaciones.*') ? 'active' : '' }}" href="{{ route('notificaciones.index') }}">
        <i class="bi bi-bell"></i> Notificaciones
    </a>
</nav>