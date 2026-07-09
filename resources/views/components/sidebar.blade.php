<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand mb-4 text-center">
        <strong>Sistema de Gestion de incidencias</strong>
    </div>

    @php
        $rol = auth()->user()->rol->nombre ?? null;
    @endphp

    @switch($rol)
        @case('Administrador')
            @include('components.sidebars.admin')
            @break

        @case('Operador')
            @include('components.sidebars.operador')
            @break

        @case('Responsable')
            @include('components.sidebars.responsable')
            @break

        @case('Ciudadano')
            @include('components.sidebars.ciudadano')
            @break

        @default
            <p class="text-muted">Rol no asignado</p>
    @endswitch
</aside>