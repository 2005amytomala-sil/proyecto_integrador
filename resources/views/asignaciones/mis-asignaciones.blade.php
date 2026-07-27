@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2>Mis Asignaciones</h2>
        <p class="text-muted">
            Aquí se muestran todas las incidencias que le han sido asignadas.
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Prioridad</th>
                            <th>Acción</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($incidencias as $incidencia)

                        <tr>

                            <td>{{ $incidencia->id }}</td>

                            <td>{{ $incidencia->titulo }}</td>

                            <td>{{ $incidencia->tipoIncidencia->nombre }}</td>

                            <td>

                                <span class="badge bg-warning text-dark">

                                    {{ $incidencia->estado->nombre }}

                                </span>

                            </td>

                            <td>

                                {{ $incidencia->prioridad->nombre }}

                            </td>

                            <td>

                                <a
                                    href="{{ route('asignaciones.mias.show', $incidencia->id) }}"
                                    class="btn btn-sm btn-outline-primary">

                                    Ver

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6" class="text-center py-4">

                                No tiene incidencias asignadas.

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