@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-3 d-flex align-items-center gap-3">
        <a href="{{ route('incidencias.index') }}" class="text-decoration-none text-muted d-flex align-items-center">
            <i class="bi bi-arrow-left fs-4 me-2"></i>
            <span class="small">Volver a Incidencias</span>
        </a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h2 class="h4 mb-0">Nueva Incidencia</h2>
            <small class="text-muted">Registre una nueva incidencia en el sistema</small>
        </div>
    </div>

    <form id="incidenciaForm" action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @php
            $usuario = auth()->user();
            $rol = $usuario->rol->nombre;
        @endphp
        <div class="row">
            <div class="col-lg-8">
                <div class="card dashboard-card mb-3">
                    <div class="card-body">
                        <h5 class="mb-3">Información del Incidente</h5>

                        <div class="row gy-3">
                            <div class="col-md-12">
                                <label class="form-label">Título</label>
                                <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" required>
                                @error('titulo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="4" required>{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tipo</label>
                                <select name="tipo_incidencia_id" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->id }}" {{ old('tipo_incidencia_id') == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo_incidencia_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Subtipo</label>
                                <select name="subtipo_incidencia_id" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($subtipos as $subtipo)
                                        <option value="{{ $subtipo->id }}" {{ old('subtipo_incidencia_id') == $subtipo->id ? 'selected' : '' }}>
                                            {{ $subtipo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subtipo_incidencia_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card dashboard-card mb-3">
                    <div class="card-body">
                        <h5 class="mb-3">Ubicación</h5>

                        <div class="row gy-3">
                            <div class="col-md-4">
                                <label class="form-label">Ciudad</label>
                                <select name="ciudad_id" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($ciudades as $ciudad)
                                        <option value="{{ $ciudad->id }}" {{ old('ciudad_id') == $ciudad->id ? 'selected' : '' }}>
                                            {{ $ciudad->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ciudad_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Latitud</label>
                                <input type="text" name="latitud" class="form-control" value="{{ old('latitud') }}">
                                @error('latitud')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Longitud</label>
                                <input type="text" name="longitud" class="form-control" value="{{ old('longitud') }}">
                                @error('longitud')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="form-label">Mapa</label>
                            <div class="border rounded-3 bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                                <span class="text-muted">Espacio reservado para mapa</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card dashboard-card mb-3">
                    <div class="card-body">
                        <h6 class="mb-3">Configuración</h6>

                        <div class="mb-3">
                            <label class="form-label">Prioridad</label>
                            <select name="prioridad_id" class="form-select" required>
                                <option value="">Seleccione...</option>
                                @foreach($prioridades as $prioridad)
                                    <option value="{{ $prioridad->id }}" {{ old('prioridad_id') == $prioridad->id ? 'selected' : '' }}>
                                        {{ $prioridad->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prioridad_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ciudadano Reportante</label>

                            @if($rol === 'Ciudadano')

                                <input type="hidden"
                                    name="ciudadano_id"
                                    value="{{ $usuario->id }}">

                                <input type="text"
                                    class="form-control"
                                    value="{{ $usuario->nombres }} {{ $usuario->apellidos }}"
                                    disabled>

                            @else

                                <select name="ciudadano_id" class="form-select" required>
                                    <option value="">Seleccione...</option>

                                    @foreach($ciudadanos as $ciudadano)
                                        <option value="{{ $ciudadano->id }}"
                                            {{ old('ciudadano_id') == $ciudadano->id ? 'selected' : '' }}>
                                            {{ $ciudadano->nombres }} {{ $ciudadano->apellidos }}
                                        </option>
                                    @endforeach
                                </select>

                            @endif

                            @error('ciudadano_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card dashboard-card mb-3">
                    <div class="card-body">
                        <h6 class="mb-3">Evidencia</h6>
                        <label class="upload-dropzone mb-3" id="uploadDropzone" for="evidenciaInput">
                            <div class="upload-icon mb-2">
                                <i class="bi bi-cloud-arrow-up fs-2"></i>
                            </div>
                            <div class="fw-semibold" id="uploadDropText">Haga clic para cargar o arrastre las imágenes aquí</div>
                            <div class="text-muted small">PNG, JPG o JPEG (máx. 5MB cada una)</div>
                            <input type="file" id="evidenciaInput" name="evidencia[]" class="form-control upload-input" accept="image/png,image/jpeg" multiple />
                            <div class="upload-preview-grid d-none" id="uploadPreviewContainer"></div>
                        </label>
                        @error('evidencia')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div class="text-muted small">Opcional: puedes agregar una imagen o documento de apoyo.</div>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-2 mt-3">
                    <button type="submit" class="btn btn-primary px-4">Guardar incidencia</button>
                    <a href="{{ route('incidencias.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropzone = document.getElementById('uploadDropzone');
        const input = document.getElementById('evidenciaInput');
        const previewContainer = document.getElementById('uploadPreviewContainer');
        const uploadText = document.getElementById('uploadDropText');

        function clearPreview() {
            previewContainer.innerHTML = '';
            previewContainer.classList.add('d-none');
            uploadText.textContent = 'Haga clic para cargar o arrastre las imágenes aquí';
        }

        function updatePreview(files) {
            if (!files || files.length === 0) {
                clearPreview();
                return;
            }

            previewContainer.innerHTML = '';
            Array.from(files).forEach(function (file) {
                if (!file.type.startsWith('image/')) {
                    return;
                }

                const reader = new FileReader();
                const previewItem = document.createElement('div');
                previewItem.className = 'upload-preview-item';
                const img = document.createElement('img');
                previewItem.appendChild(img);
                previewContainer.appendChild(previewItem);

                reader.onload = function (event) {
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            });

            previewContainer.classList.remove('d-none');
            uploadText.textContent = files.length === 1 ? '1 archivo listo para subir' : files.length + ' archivos listos para subir';
        }

        input.addEventListener('change', function () {
            updatePreview(input.files);
        });

        dropzone.addEventListener('dragover', function (event) {
            event.preventDefault();
            dropzone.classList.add('drag-active');
        });

        dropzone.addEventListener('dragleave', function () {
            dropzone.classList.remove('drag-active');
        });

        dropzone.addEventListener('drop', function (event) {
            event.preventDefault();
            dropzone.classList.remove('drag-active');
            if (event.dataTransfer.files.length) {
                input.files = event.dataTransfer.files;
                updatePreview(input.files);
            }
        });
    });
</script>
@endpush
@endsection