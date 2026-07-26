@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-0">
                Informes y Estadísticas
            </h1>

            <p class="text-muted mb-0">
                Analice el comportamiento de las incidencias registradas.
            </p>
        </div>

        <div class="d-flex gap-2">

            <button class="btn btn-outline-success">
                <i class="bi bi-file-earmark-excel"></i>
                Exportar Excel
            </button>

            <button class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf"></i>
                Exportar PDF
            </button>

        </div>

    </div>

    <!--Filtros para los informes y estadisticas-->
    <div class="card dashboard-card mb-4">
        <div class="card-body">
            <h5 class="mb-3">
                Filtros del Informe
            </h5>

            <form id="formFiltros" method="GET" action="{{ route('informes.index') }}">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">
                            Fecha inicio
                        </label>
                        <input 
                            type="date" 
                            name="fecha_inicio"
                            value="{{ request('fecha_inicio') }}"
                            class="form-control filtro-auto">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">
                            Fecha fin
                        </label>
                        <input 
                            type="date"
                            name="fecha_fin"
                            value="{{ request('fecha_fin') }}"
                            class="form-control filtro-auto">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">
                            Provincia
                        </label>
                        <select 
                            name="provincia_id"
                            class="form-select filtro-auto">
                            <option value="">
                                Todas
                            </option>
                            @foreach($provincias as $provincia)
                                <option 
                                    value="{{ $provincia->id }}"
                                    {{ request('provincia_id') == $provincia->id ? 'selected' : '' }}>

                                    {{ $provincia->nombre }}

                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">
                            Categoría
                        </label>
                        <select 
                            name="categoria_id"
                            class="form-select filtro-auto">
                            <option value="">
                                Todas
                            </option>
                            @foreach($categorias as $categoria)

                                <option 
                                    value="{{ $categoria->id }}"
                                    {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}

                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">
                            Estado
                        </label>

                        <select 
                            name="estado_id"
                            class="form-select filtro-auto">
                            <option value="">
                                Todos
                            </option>
                            @foreach($estados as $estado)
                                <option 
                                    value="{{ $estado->id }}"
                                    {{ request('estado_id') == $estado->id ? 'selected' : '' }}>

                                    {{ $estado->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <a
                            href="{{ route('informes.index') }}"
                            class="btn btn-outline-secondary w-100">

                            Limpiar filtros

                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--Tarjetas KPIs-->
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body">

                    <div class="text-muted">
                        Total incidencias
                    </div>

                    <h2 class="fw-bold mt-2">
                        {{ $kpis['total'] }}
                    </h2>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body">

                    <div class="text-muted">
                        {{ $kpis['titulo_estado'] }}
                    </div>

                    <h2 class="fw-bold mt-2">
                        {{ $kpis['cantidad_estado'] }}
                    </h2>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body">

                    <div class="text-muted">
                        {{ $kpis['titulo_tiempo'] }}
                    </div>

                    <h2 class="fw-bold mt-2">
                        {{ $kpis['tiempo_estado'] }}
                    </h2>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body">

                    <div class="text-muted">
                        Ciudad con más incidencias
                    </div>

                    <h2 class="fw-bold mt-2">
                        {{ $kpis['ciudad_lider']}}
                    </h2>

                </div>
            </div>
        </div>

    </div>

    <!--Graficos-->
    <div class="row">
        <!-- Grafico flujo estados -->
        <div class="col-md-6 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <h5 class="mb-3">
                        Flujo de estados de incidencias
                    </h5>
                    <canvas id="graficoFlujoEstados"></canvas>
                    <script>
                        window.flujoEstados = @json($flujoEstados);
                    </script>
                </div>
            </div>
        </div>

        <!-- Segundo grafico -->
        <div class="col-md-6 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <h5 class="mb-3">
                        {{ $incidenciasCategoria['titulo'] }}
                    </h5>
                    <canvas id="graficoCategoria"></canvas>
                    <script>
                        window.incidenciasCategoria = @json($incidenciasCategoria);
                    </script>
                </div>
            </div>
        </div>
</div>

</div>
@endsection


