@extends('layouts.app')

@section('content')
<div class="container-fluid" data-page="incidencias">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar">
            </button>
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-0">Gestión de Incidentes</h1>
            <p class="text-muted mb-0">Administre todos los incidentes reportados</p>
        </div>
        <a href="{{ route('incidencias.create') }}" class="btn btn-primary">+ Nuevo Incidente</a>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row gy-2 gx-3 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="search" id="incidencias-search" class="form-control" placeholder="Buscar por título o descripción...">
                    </div>
                </div>
                <div class="col-md-2">
                    <select id="filter-estado" class="form-select">
                        <option value="">Todos los estados</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="filter-prioridad" class="form-select">
                        <option value="">Todas las prioridades</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="filter-tipo" class="form-select">
                        <option value="">Todas las categorías</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <button id="clear-filters" class="btn btn-outline-secondary">Limpiar filtros</button>
                </div>
            </div>
            <p class="text-muted small mt-3" id="incidencias-count">Mostrando 0 incidentes</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="incidencias-table">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Subtipo</th>
                            <th>Ciudad</th>
                            <th>Ciudadano</th>
                            <th>Estado</th>
                            <th>Prioridad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows injected by JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    @vite('resources/js/incidencias.js')
@endpush
