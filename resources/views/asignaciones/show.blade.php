@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <a href="{{ route('asignaciones.index') }}"
           class="btn btn-outline-secondary btn-sm mb-3">

            ← Volver

        </a>

        <h2>

            Incidencia #{{ $incidencia->id }}

        </h2>

        <p class="text-muted">

            {{ $incidencia->titulo }}

        </p>

    </div>

<div class="card shadow-sm mb-4">

    <div class="card-header">

        Información General

    </div>

    @if(!$incidencia->responsablePrincipal)

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">
            Asignación de personal
        </h5>
    </div>

    <div class="card-body">

        <form action="{{ route('asignaciones.store', $incidencia->id) }}" method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Responsable principal
                </label>

                <select
                    name="responsable_id"
                    class="form-select"
                    required>

                    <option value="">
                        Seleccione...
                    </option>

                    @foreach($trabajadores as $trabajador)

                        <option value="{{ $trabajador->id }}">

                            {{ $trabajador->nombres }}
                            {{ $trabajador->apellidos }}

                        </option>

                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Personal de apoyo
                </label>

                <select
                    id="selectApoyo"
                    class="form-select">

                    <option value="">
                        Seleccione personal de apoyo...
                    </option>

                    @foreach($trabajadores as $trabajador)

                        <option 
                            value="{{ $trabajador->id }}"
                            data-nombre="{{ $trabajador->nombres }} {{ $trabajador->apellidos }}">

                            {{ $trabajador->nombres }}
                            {{ $trabajador->apellidos }}

                        </option>

                    @endforeach
                </select>
                <div id="listaApoyos" class="mt-3">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">

                    Observación

                </label>

                <textarea
                    class="form-control"
                    rows="4"
                    name="observacion"></textarea>

            </div>

            <button class="btn btn-primary">

                Guardar asignación

            </button>

        </form>

    </div>

</div>
@else
<div class="card shadow-sm">

    <div class="card-header">
        Personal asignado
    </div>

    <div class="card-body">

        <div class="mb-3">

            <strong>Responsable principal</strong>

            <p>

                {{ $incidencia->responsablePrincipal->usuario->nombres }}
                {{ $incidencia->responsablePrincipal->usuario->apellidos }}

            </p>

        </div>

        <div class="mb-3">

            <strong>Personal de apoyo</strong>

            <ul>

                @forelse($incidencia->apoyos as $apoyo)

                    <li>

                        {{ $apoyo->usuario->nombres }}
                        {{ $apoyo->usuario->apellidos }}

                    </li>

                @empty

                    <li>No hay personal de apoyo.</li>

                @endforelse

            </ul>

        </div>

        @if($incidencia->responsablePrincipal->observacion)

            <div>

                <strong>Observación</strong>

                <p>

                    {{ $incidencia->responsablePrincipal->observacion }}

                </p>

            </div>

        @endif

    </div>

</div>
@endif

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">

                <strong>Ciudadano</strong>

                <br>

                {{ $incidencia->ciudadano->nombres }}

                {{ $incidencia->ciudadano->apellidos }}

            </div>

            <div class="col-md-6 mb-3">

                <strong>Estado</strong>

                <br>

                {{ $incidencia->estado->nombre }}

            </div>

            <div class="col-md-6 mb-3">

                <strong>Tipo</strong>

                <br>

                {{ $incidencia->tipoIncidencia->nombre }}

            </div>

            <div class="col-md-6 mb-3">

                <strong>Subtipo</strong>

                <br>

                {{ $incidencia->subtipoIncidencia->nombre }}

            </div>

            <div class="col-12">

                <strong>Descripción</strong>

                <br>

                {{ $incidencia->descripcion }}

            </div>

        </div>

    </div>

</div>
@endsection