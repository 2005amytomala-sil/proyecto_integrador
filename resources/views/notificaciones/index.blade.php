@extends('layouts.app')

@section('content')
<div class="container-fluid p-4" data-page="notificaciones">
    
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-secondary active filter-btn" data-estado="todos">Todo</button>
            <button type="button" class="btn btn-outline-secondary filter-btn" data-estado="no_leido">No leído</button>
        </div>

        <div class="flex-grow-1 max-w-500px ms-md-2">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" id="buscarNotificacion" class="form-control" placeholder="Notificaciones de búsqueda...">
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <label class="text-nowrap text-muted small">Ordenar por:</label>
            <select id="ordenarNotificacion" class="form-select form-select-sm">
                <option value="desc">Más reciente a más antiguo</option>
                <option value="asc">Más antiguo a más reciente</option>
            </select>
        </div>
    </div>

    <div class="card shadow-sm rounded-3">
        <div class="card-header bg-light py-3 d-flex align-items-center justify-content-between">
            <span class="fw-bold text-secondary">Bandeja de Entrada</span>
            <span id="totalCount" class="badge bg-secondary">0 notificaciones</span>
        </div>
        <div class="list-group list-group-flush" id="notificacionesContainer">
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/notificaciones.js')
@endpush