@extends('layouts.app')

@section('content')
@php
    $usuario = auth()->user();
    $rol = $usuario->rol->nombre;
@endphp

<div class="container-fluid">

    <div class="mb-3 d-flex align-items-center gap-3">
        <a href="{{ route('incidencias.index') }}" class="text-decoration-none text-muted d-flex align-items-center">
            <i class="bi bi-arrow-left fs-4 me-2"></i>
            <span class="small">Volver a Incidencias</span>
        </a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h2 class="h4 mb-0">{{ $incidencia->titulo }}</h2>
            <small class="text-muted">Incidente #{{ $incidencia->id }}</small>
        </div>

        <div class="d-flex align-items-center gap-2">
            @if(
                in_array($rol, ['Administrador', 'Operador']) ||
                ($rol === 'Ciudadano' && $usuario->id == $incidencia->ciudadano_id)
            )
                <a href="{{ route('incidencias.edit', $incidencia->id) }}"
                class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar Incidencia
                </a>
            @endif

            @if(
                in_array($rol, ['Administrador', 'Operador']) ||
                (
                    $rol === 'Ciudadano' &&
                    $usuario->id == $incidencia->ciudadano_id &&
                    in_array($incidencia->estado->nombre, [
                        'Registrada',
                        'Rechazada',
                        'Cancelada'
                    ])
                )
            )
            <form action="{{ route('incidencias.destroy', $incidencia->id) }}"
                method="POST"
                onsubmit="return confirm('¿Está seguro de eliminar esta incidencia? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-trash me-1"></i>
                    Eliminar
                </button>
            </form>
            @endif

        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card dashboard-card mb-3">
                <div class="card-body">
                    <h5 class="mb-3">Detalles del Incidente</h5>

                    <div class="mb-3">
                        <div class="small text-muted">Descripción</div>
                        <div>{{ $incidencia->descripcion }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <div class="small text-muted">Categoría</div>
                            <div class="fw-semibold">{{ $incidencia->tipoIncidencia->nombre ?? '—' }}
                                <div class="text-muted small">{{ $incidencia->subtipoIncidencia->nombre ?? '' }}</div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="small text-muted">Prioridad</div>
                            <div>
                                @if(optional($incidencia->prioridad)->nombre)
                                    @php
                                        $prioridadNombre = $incidencia->prioridad->nombre;
                                        $prioridadClass = match(strtolower($prioridadNombre)) {
                                            'baja' => 'bg-success',
                                            'media', 'media-baja', 'moderada' => 'bg-warning text-dark',
                                            'alta', 'urgente' => 'bg-danger',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $prioridadClass }}">{{ $prioridadNombre }}</span>
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="small text-muted">Ubicación</div>
                        <div>
                            <i class="bi bi-geo-alt-fill me-1"></i>
                            {{ optional($incidencia->ciudad)->nombre ?? 'Sin ciudad' }}
                            <div class="small text-muted">Coordenadas: {{ $incidencia->latitud ?? '—' }}, {{ $incidencia->longitud ?? '—' }}</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="small text-muted">Evidencias Fotográficas</div>
                        <div class="mt-2">
                            @if(optional($incidencia)->evidencias && count($incidencia->evidencias) > 0)
                                @foreach($incidencia->evidencias as $ev)
                                    @if(!empty($ev->archivo) || !empty($ev->url))
                                        <img src="{{ $ev->url ?? asset('storage/' . $ev->archivo) }}" alt="evidencia" class="img-fluid rounded mb-2" style="max-width:220px;" />
                                    @endif
                                @endforeach
                            @else
                                <div class="text-muted">No hay evidencias registradas.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card dashboard-card mb-3">
                <div class="card-body">
                    <h5 class="mb-3">Ubicación en Mapa</h5>
                    <div id="incidencia-map" style="height:220px; border-radius:8px; background:#f5f7fa; display:flex;align-items:center;justify-content:center; color:#9aa3ad;">Mapa (pendiente)</div>
                </div>
            </div>

            <div class="card dashboard-card mb-3">
                <div class="card-body">
                    <h5 class="mb-3">Comentarios ({{ optional($incidencia->comentarios)->count() ?? 0 }})</h5>

                    @if(optional($incidencia)->comentarios && $incidencia->comentarios->count())
                        @foreach($incidencia->comentarios as $comentario)
                            <div class="d-flex mb-3">
                                <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;">
                                    {{ strtoupper(substr($comentario->autor_nombre ?? 'U',0,1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $comentario->autor_nombre ?? 'Usuario' }} <small class="text-muted">· {{ optional($comentario->created_at)->format('d/m/Y H:i') }}</small></div>
                                    <div class="text-muted">{{ $comentario->texto ?? $comentario->contenido ?? '' }}</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-muted">No hay comentarios todavía.</div>
                    @endif

                    <div class="mt-3">
                        <form action="#" method="POST">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Escribir un comentario...">
                                <button class="btn btn-primary" type="button">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card dashboard-card mb-3">
                <div class="card-body">
                    <h6 class="mb-3">Estado Actual</h6>

                    <div class="mb-3">
                        @if(optional($incidencia->estado)->nombre)
                            <span class="badge bg-info text-dark">
                                {{ $incidencia->estado->nombre }}
                            </span>
                        @else
                            <span class="text-muted">Sin estado</span>
                        @endif
                    </div>

                </div>
            </div>

            <div class="card dashboard-card mb-3 reportado-card">
                <div class="card-body">
                    <div class="small text-muted mb-2"><i class="bi bi-person-fill me-1"></i> Reportado por</div>

                    @php
                        $n = optional($incidencia->ciudadano)->nombres ?? '';
                        $a = optional($incidencia->ciudadano)->apellidos ?? '';
                        $initials = strtoupper(substr($n,0,1) . substr($a,0,1));
                        if(trim($initials) == '') { $initials = strtoupper(substr($n.$a,0,1) ?: 'U'); }
                    @endphp

                    <div class="d-flex align-items-center mt-2">
                        <div class="profile-avatar me-3">{{ $initials }}</div>
                        <div>
                            <div class="report-name">{{ trim(optional($incidencia->ciudadano)->nombres.' '.optional($incidencia->ciudadano)->apellidos) ?: 'Ciudadano' }}</div>
                            <div class="report-role small">Ciudadano</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card dashboard-card mb-3">
                <div class="card-body">
                    <h6 class="mb-2">Fechas</h6>
                    <div class="small text-muted">Creado</div>
                    <div class="fw-semibold mb-2">{{ optional($incidencia->created_at)->format('d \d\e F \d\e Y \a \l\a\s H:i') ?? '' }}</div>

                    <div class="small text-muted">Última actualización</div>
                    <div class="fw-semibold">{{ optional($incidencia->updated_at)->format('d \d\e F \d\e Y \a \l\a\s H:i') ?? '' }}</div>
                </div>
            </div>

            <div class="card dashboard-card mb-3">
                <div class="card-body">
                    <h6 class="mb-3">Historial de Estados</h6>

                    @if($incidencia->historialEstados->count())
                        <div class="estado-timeline">
                            @foreach($incidencia->historialEstados as $historial)
                                @php
                                    $usuario = $historial->usuario;

                                    $nombreUsuario = $usuario
                                        ? trim($usuario->nombres . ' ' . $usuario->apellidos)
                                        : 'Usuario no disponible';
                                @endphp

                                <div class="d-flex mb-3">
                                    <div class="me-3">
                                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary"
                                            style="width: 28px; height: 28px;">
                                            <i class="bi bi-check-circle"></i>
                                        </span>
                                    </div>

                                    <div class="flex-grow-1">
                                        <div class="fw-semibold">
                                            {{ $historial->estado->nombre ?? 'Estado no disponible' }}
                                        </div>

                                        <div class="small text-muted">
                                            Cambiado por {{ $nombreUsuario }}
                                        </div>

                                        <div class="small text-muted">
                                            {{ optional($historial->created_at)->format('d/m/Y H:i') }}
                                        </div>

                                        @if($historial->observacion)
                                            <div class="small mt-1">
                                                {{ $historial->observacion }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted">
                            No hay cambios de estado registrados.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection