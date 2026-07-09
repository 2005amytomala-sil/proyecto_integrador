@extends('layouts.guest')

@section('content')

<div class="container register-container">
    <div class="card card-register mb-3 shadow-lg">
    <img class="img-register" src="{{ asset('img/login/register.png') }}" class="card-img-top" alt="Registro ciudadano">
    <div class="card-body register-body">
        <h4 class="card-title text-center">Registro ciudadano</h4>
        <p class="card-text text-center">Crea tu cuenta para reportar incidencias.</p>
        <form method="POST" action="{{ route('register.store') }}" class="row g-3">
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
                <input type="text" name="cedula" class="form-control" value="{{ old('cedula') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nombres</label>
                <input type="text" name="nombres" class="form-control" value="{{ old('nombres') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}" required>
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail4" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-6">
                <label for="inputPhone" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" id="inputPhone" value="{{ old('telefono') }}" required>
            </div>
            <div class="col-md-6">
                <label for="inputCountry" class="form-label">País</label>
                <select id="inputCountry" class="form-select">
                <option selected>Seleccione un país</option>
                <option>...</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="inputProvince" class="form-label">Provincia</label>
                <select id="inputProvince" class="form-select">
                <option selected>Seleccione una provincia</option>
                <option>...</option>
                </select>
            </div>
            <!--ARREGLO MOMENTANEO, TERMINAR DE IMPLEMENTAR PAIS,PROVINCIA Y CIUDAD DESPUES
                DE MOMENTO CARGA DIRECTAMENTE LA CIUDAD-->
            <div class="col-md-4">
                <label for="inputCity" class="form-label">Ciudad</label>
                <select id="inputCity" name="ciudad_id" class="form-select" required>
                <option value="">Seleccione una ciudad</option>
                @foreach ($ciudades as $ciudad)
                    <option
                        value="{{ $ciudad->id }}"
                        {{ old('ciudad_id') == $ciudad->id ? 'selected' : '' }}>
                        {{ $ciudad->nombre }}
                    </option>
                @endforeach
            </select>
            </div>
            <div class="col-md-8">
                <label for="inputAddress" class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" id="inputAddress" placeholder="1234 Main St" value="{{ old('direccion') }}">
            </div>
            <div class="col-md-6">
                <label for="inputPassword" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" id="inputPassword" required>
            </div>
            <div class="col-md-6">
                <label for="inputPasswordConfirm" class="form-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" id="inputPasswordConfirm">   
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">
                    Registrar
                </button>
            </div>
            <div class="text-center mt-3">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}">Iniciar sesión</a>
            </div>
        </form>
    </div>
    </div>
</div>

@endsection