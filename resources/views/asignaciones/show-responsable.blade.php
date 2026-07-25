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

    </div>

</div>

@endsection