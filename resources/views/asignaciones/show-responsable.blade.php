@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <a href="{{ route('asignaciones.mias') }}"
       class="btn btn-outline-secondary btn-sm mb-3">

        ← Volver

    </a>

    <div class="card shadow-sm">

        <div class="card-header">

            <h4 class="mb-0">
                Incidencia #{{ $incidencia->id }}
            </h4>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <strong>Título</strong><br>
                    {{ $incidencia->titulo }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Estado</strong><br>
                    {{ $incidencia->estado->nombre }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Tipo</strong><br>
                    {{ $incidencia->tipoIncidencia->nombre }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Subtipo</strong><br>
                    {{ $incidencia->subtipoIncidencia->nombre }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Prioridad</strong><br>
                    {{ $incidencia->prioridad->nombre }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Ciudadano</strong><br>
                    {{ $incidencia->ciudadano->nombres }}
                    {{ $incidencia->ciudadano->apellidos }}
                </div>

                <div class="col-12 mb-3">
                    <strong>Descripción</strong><br>
                    {{ $incidencia->descripcion }}
                </div>

            </div>

        </div>

        @if($incidencia->estado->nombre != 'Resuelta')
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                Subir evidencia
            </div>
        @endif

            <div class="card-body">

                <form
                    action="{{ route('evidencias.store', $incidencia->id) }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Tipo de evidencia</label>

                        <select
                            name="tipo"
                            class="form-select"
                            required>

                            <option value="">Seleccione...</option>
                            <option value="antes">Antes</option>
                            <option value="despues">Después</option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Imagen</label>

                        <input
                            type="file"
                            name="archivo"
                            class="form-control"
                            accept="image/*"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>

                        <textarea
                            name="descripcion"
                            rows="3"
                            class="form-control"></textarea>
                    </div>

                    <button
                        class="btn btn-success">

                        Subir evidencia

                    </button>

                </form>

            </div>

        </div>
        <div class="card shadow-sm mt-4">

            <div class="card-header">
                Evidencias
            </div>

            <div class="card-body">

                <h5>Antes</h5>

                <div class="row">

                    @forelse($incidencia->evidenciasAntes as $evidencia)

                        <div class="col-md-4 mb-3">

                            <div class="card">

                                <img
                                src="{{ asset('storage/'.$evidencia->archivo) }}"
                                class="card-img-top"
                                style="
                                    height:250px;
                                    object-fit:contain;
                                    background:#f8f9fa;
                                ">

                                <div class="card-body">

                                    @if($evidencia->descripcion)
                                        <p class="mb-2">
                                            {{ $evidencia->descripcion }}
                                        </p>
                                    @endif

                                    <small class="text-muted d-block">
                                        Subido por:
                                        {{ $evidencia->usuario->nombres }}
                                        {{ $evidencia->usuario->apellidos }}
                                    </small>

                                    <small class="text-muted">
                                        {{ $evidencia->created_at->format('d/m/Y H:i') }}
                                    </small>

                                </div>

                            </div>

                        </div>

                    @empty

                        <p class="text-muted">
                            No existen evidencias.
                        </p>

                    @endforelse

                </div>

                <hr>

                <h5>Después</h5>

                <div class="row">

                    @forelse($incidencia->evidenciasDespues as $evidencia)

                        <div class="col-md-4 mb-3">

                            <div class="card">

                                
                                <img
                                src="{{ asset('storage/'.$evidencia->archivo) }}"
                                class="card-img-top"
                                style="
                                    height:250px;
                                    object-fit:contain;
                                    background:#f8f9fa;
                                ">

                                <div class="card-body">

                                    @if($evidencia->descripcion)
                                        <p class="mb-2">
                                            {{ $evidencia->descripcion }}
                                        </p>
                                    @endif

                                    <small class="text-muted d-block">
                                        Subido por:
                                        {{ $evidencia->usuario->nombres }}
                                        {{ $evidencia->usuario->apellidos }}
                                    </small>

                                    <small class="text-muted">
                                        {{ $evidencia->created_at->format('d/m/Y H:i') }}
                                    </small>

                                </div>

                            </div>

                        </div>

                    @empty

                        <p class="text-muted">
                            No existen evidencias.
                        </p>

                    @endforelse

                </div>

                @if($incidencia->estado->nombre != 'Resuelta' && $incidencia->evidenciasDespues->count())
                    <div class="card shadow-sm mt-4">

                        <div class="card-body text-end">
                            <form
                                action="{{ route('incidencias.resolver', $incidencia) }}"
                                method="POST">

                                @csrf
                                @method('PATCH')

                                <button
                                    class="btn btn-success">

                                    ✔ Marcar como resuelta
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                @if($incidencia->estado->nombre == 'Resuelta')
                <div class="alert alert-success mt-4">
                    <h5 class="mb-2">
                        ✔ Incidencia resuelta
                    </h5>

                    <p class="mb-0">
                        Esta incidencia fue marcada como resuelta.
                        <br>
                        Fecha de resolución:
                        <strong>

                            {{ $incidencia->fecha_resolucion?->format('d/m/Y H:i') }}
                        </strong>
                    </p>
                </div>
                @endif
                
            </div>

        </div>

    </div>

</div>

@endsection