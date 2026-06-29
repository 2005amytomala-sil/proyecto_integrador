@extends('layouts.guest')

@section('content')

<div class="container register-container">
    <div class="card card-register mb-3 shadow-lg">
    <img class="img-register" src="{{ asset('img/login/register.png') }}" class="card-img-top" alt="Registro ciudadano">
    <div class="card-body register-body">
        <h4 class="card-title text-center">Registro ciudadano</h4>
        <p class="card-text text-center">Crea tu cuenta para reportar incidencias.</p>
        <form class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombres</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Apellidos</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail4">
            </div>
            <div class="col-md-6">
                <label for="inputPhone" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="inputPhone">
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
            <div class="col-md-4">
                <label for="inputCity" class="form-label">Ciudad</label>
                <select id="inputCity" class="form-select">
                <option selected>Seleccione una ciudad</option>
                <option>...</option>
                </select>
            </div>
            <div class="col-md-8">
                <label for="inputAddress" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
            </div>
            <div class="col-md-6">
                <label for="inputPassword" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="inputPassword">
            </div>
            <div class="col-md-6">
                <label for="inputPasswordConfirm" class="form-label">Confirmar contraseña</label>
                <input type="password" class="form-control" id="inputPasswordConfirm">   
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