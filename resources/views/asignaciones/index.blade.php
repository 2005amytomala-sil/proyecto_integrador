@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Gestión de Asignaciones</h1>
            <p class="text-muted mb-0">
                Administre las asignaciones de incidencias.
            </p>
        </div>
    </div>

    {{-- Pendientes --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0">Pendientes de asignar</h5>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th width="120">Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($pendientes as $incidencia)

                            <tr>

                                <td>{{ $incidencia->id }}</td>

                                <td>{{ $incidencia->titulo }}</td>

                                <td>{{ $incidencia->tipoIncidencia->nombre }}</td>

                                <td>
                                    <span class="badge bg-primary">
                                        {{ $incidencia->estado->nombre }}
                                    </span>
                                </td>

                                <td>

                                    <a href="{{ route('asignaciones.show', $incidencia) }}"
                                       class="btn btn-warning btn-sm">

                                        <i class="bi bi-person-plus"></i>

                                        Asignar

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center text-muted py-4">

                                    No existen incidencias pendientes de asignar.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- Asignadas --}}

    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">

                Incidencias asignadas

            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>ID</th>

                            <th>Título</th>

                            <th>Responsable</th>

                            <th>Estado</th>

                            <th width="100">Acción</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($asignadas as $incidencia)

                            <tr>

                                <td>{{ $incidencia->id }}</td>

                                <td>{{ $incidencia->titulo }}</td>

                                <td>

                                    {{ $incidencia->responsablePrincipal->usuario->nombres }}

                                    {{ $incidencia->responsablePrincipal->usuario->apellidos }}

                                </td>

                                <td>

                                    <span class="badge bg-warning text-dark">

                                        {{ $incidencia->estado->nombre }}

                                    </span>

                                </td>

                                <td>

                                    <a href="{{ route('asignaciones.show', $incidencia) }}"

                                       class="btn btn-outline-primary btn-sm">

                                        <i class="bi bi-eye"></i>

                                        Ver

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center text-muted py-4">

                                    No existen incidencias asignadas.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
@endsection