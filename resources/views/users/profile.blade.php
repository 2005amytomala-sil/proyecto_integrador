@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Encabezado de la página -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold mb-0">Perfil de Usuario</h3>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="row g-4">
        <!-- Tarjeta de Información General -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="mx-auto mb-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ strtoupper(substr($user->nombres, 0, 1)) }}{{ strtoupper(substr($user->apellidos, 0, 1)) }}
                </div>

                <h5 class="fw-bold mb-1">{{ $user->nombres }} {{ $user->apellidos }}</h5>
                <span class="badge bg-info text-dark mb-3 align-self-center">
                    {{ $user->rol->nombre ?? 'Sin Rol' }}
                </span>

                <hr>

                <div class="text-start fs-7">
                    <p class="mb-2 text-muted">
                        <i class="bi bi-envelope me-2"></i>{{ $user->email }}
                    </p>
                    <p class="mb-2 text-muted">
                        <i class="bi bi-geo-alt me-2"></i>{{ $user->ciudad->nombre ?? 'No especificada' }}
                    </p>
                    <p class="mb-0 text-muted">
                        <i class="bi bi-calendar-check me-2"></i>Miembro desde {{ $user->created_at->translatedFormat('F Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Estadísticas y Actividad Reciente -->
        <div class="col-md-8">
            <!-- Métricas Resumen -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6">
                    <div class="card border-0 shadow-sm p-3">
                        <div class="d-flex align-items-center">
                            <div class="p-3 bg-primary-subtle text-primary rounded me-3">
                                <i class="bi bi-file-earmark-text fs-3"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Total Incidencias</small>
                                <span class="fs-4 fw-bold">{{ $totalIncidencias }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card border-0 shadow-sm p-3">
                        <div class="d-flex align-items-center">
                            <div class="p-3 bg-success-subtle text-success rounded me-3">
                                <i class="bi bi-graph-up-arrow fs-3"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Registradas este mes</small>
                                <span class="fs-4 fw-bold">{{ $incidenciasEsteMes }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Últimas Incidencias Reportadas -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2"></i>Últimas Incidencias Reportadas</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Título</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @forelse($ultimasIncidencias as $incidencia)
                                @php
                                    $estado = strtolower(trim($incidencia->estado->nombre ?? ''));
                                    
                                    $badgeColor = match($estado) {
                                        'registrada' => 'bg-primary',
                                        'en proceso' => 'bg-warning text-dark',
                                        'validada', 'rechazada', 'cancelada' => 'bg-info text-dark',
                                        'resuelta' => 'bg-success',
                                        'cerrada' => 'bg-dark',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <tr>
                                    <td><strong>{{ $incidencia->titulo }}</strong></td>
                                    <td>
                                        <span class="badge {{ $badgeColor }}">
                                            {{ $incidencia->estado->nombre ?? '-' }}
                                        </span>
                                    </td>
                                    <td>{{ $incidencia->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('incidencias.show', $incidencia->id) }}" class="btn btn-sm btn-outline-primary">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Este usuario no ha registrado incidencias aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection