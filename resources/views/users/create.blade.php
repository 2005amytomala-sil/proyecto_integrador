@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card shadow-lg">
        <div class="card-body">

            <h3 class="text-center mb-3">
                Registrar Usuario
            </h3>

            <p class="text-center text-muted mb-4">
                Complete la información del nuevo usuario.
            </p>

            <form method="POST" action="{{ route('users.store') }}" class="row g-3">

                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="col-md-6">
                    <label class="form-label">Cédula</label>
                    <input
                        type="text"
                        name="cedula"
                        class="form-control"
                        value="{{ old('cedula') }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Rol</label>

                    <select
                        name="rol_id"
                        class="form-select"
                        required>

                        <option value="">Seleccione un rol</option>

                        @foreach($roles as $rol)

                            <option
                                value="{{ $rol->id }}"
                                {{ old('rol_id') == $rol->id ? 'selected' : '' }}>

                                {{ $rol->nombre }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-6">
                    <label class="form-label">Nombres</label>

                    <input
                        type="text"
                        name="nombres"
                        class="form-control"
                        value="{{ old('nombres') }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Apellidos</label>

                    <input
                        type="text"
                        name="apellidos"
                        class="form-control"
                        value="{{ old('apellidos') }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Teléfono</label>

                    <input
                        type="text"
                        name="telefono"
                        class="form-control"
                        value="{{ old('telefono') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">País</label>

                    <select
                        id="inputCountry"
                        name="pais_id"
                        class="form-select"
                        required>

                        <option value="">Seleccione un país</option>

                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Provincia</label>

                    <select
                        id="inputProvince"
                        name="provincia_id"
                        class="form-select"
                        required>

                        <option value="">Seleccione una provincia</option>

                    </select>

                </div>

                <div class="col-md-4">

                    <label class="form-label">Ciudad</label>

                    <select
                        id="inputCity"
                        name="ciudad_id"
                        class="form-select"
                        required>

                        <option value="">Seleccione una ciudad</option>

                    </select>

                </div>

                <div class="col-md-8">

                    <label class="form-label">Dirección</label>

                    <input
                        type="text"
                        name="direccion"
                        class="form-control"
                        value="{{ old('direccion') }}">

                </div>

                <div class="col-md-6">

                    <label class="form-label">Contraseña</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        Confirmar contraseña
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        required>

                </div>

                <div class="col-12 d-flex justify-content-end">

                    <a
                        href="{{ route('users.index') }}"
                        class="btn btn-secondary me-2">

                        Cancelar

                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Guardar Usuario

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', async () => {

    const paisSelect = document.getElementById('inputCountry');
    const provinciaSelect = document.getElementById('inputProvince');
    const ciudadSelect = document.getElementById('inputCity');

    // Cargar países
    const paises = await fetch('/api/paises');
    const listaPaises = await paises.json();

    listaPaises.forEach(pais => {
        paisSelect.innerHTML += `
            <option value="${pais.id}">
                ${pais.nombre}
            </option>
        `;
    });

    paisSelect.addEventListener('change', async () => {

        provinciaSelect.innerHTML =
            '<option value="">Seleccione una provincia</option>';

        ciudadSelect.innerHTML =
            '<option value="">Seleccione una ciudad</option>';

        if (!paisSelect.value)
            return;

        const respuesta = await fetch(`/api/provincias/${paisSelect.value}`);

        const provincias = await respuesta.json();

        provincias.forEach(provincia => {

            provinciaSelect.innerHTML += `
                <option value="${provincia.id}">
                    ${provincia.nombre}
                </option>
            `;

        });

    });

    provinciaSelect.addEventListener('change', async () => {

        ciudadSelect.innerHTML =
            '<option value="">Seleccione una ciudad</option>';

        if (!provinciaSelect.value)
            return;

        const respuesta = await fetch(`/api/ciudades/${provinciaSelect.value}`);

        const ciudades = await respuesta.json();

        ciudades.forEach(ciudad => {

            ciudadSelect.innerHTML += `
                <option value="${ciudad.id}">
                    ${ciudad.nombre}
                </option>
            `;

        });

    });

});

</script>
@endpush