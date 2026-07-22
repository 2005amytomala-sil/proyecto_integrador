@extends('layouts.app')

@section('content')
<div class="container-fluid" data-page="mis-incidencias">
    
    {{-- Encabezado de la Sección --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-0">Mis Incidencias</h1>
            <p class="text-muted mb-0">Consulte y filtre los reportes realizados por su cuenta</p>
        </div>
        <a href="{{ route('incidencias.create') }}" class="btn btn-primary">+ Nuevo Incidente</a>
    </div>

    {{-- Tarjeta de Filtros --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row gy-2 gx-3 align-items-center">
                {{-- Búsqueda por texto --}}
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="search" id="mis-incidencias-search" class="form-control" placeholder="Buscar en mis reportes...">
                    </div>
                </div>

                {{-- Filtro por Estado --}}
                <div class="col-md-2">
                    <select id="filter-estado" class="form-select">
                        <option value="">Todos los estados</option>
                    </select>
                </div>

                {{-- Filtro por Prioridad --}}
                <div class="col-md-2">
                    <select id="filter-prioridad" class="form-select">
                        <option value="">Todas las prioridades</option>
                    </select>
                </div>

                {{-- Filtro por Categoría/Tipo --}}
                <div class="col-md-2">
                    <select id="filter-tipo" class="form-select">
                        <option value="">Todas las categorías</option>
                    </select>
                </div>

                {{-- Botón para Limpiar --}}
                <div class="col-md-2 text-end">
                    <button id="clear-filters" class="btn btn-outline-secondary">Limpiar filtros</button>
                </div>
            </div>
            <p class="text-muted small mt-3" id="incidencias-count">Mostrando 0 incidentes</p>
        </div>
    </div>

    {{-- Tabla de Resultados (Vacía, JS la llenará) --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="mis-incidencias-table">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Subtipo</th>
                            <th>Ciudad</th>
                            <th>Estado</th>
                            <th>Prioridad</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las filas se inyectarán dinámicamente mediante JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    {{-- Enlazamos el archivo JS específico que crearemos en el Paso 4 --}}
    @vite('resources/js/mis-incidencias.js')
@endpush