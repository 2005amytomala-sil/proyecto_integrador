@extends('layouts.guest')

@section('content')

<div class="container login-container">
    <div class="card card-login mb-3 shadow-lg">
        <div class="row g-0">
            <div class="col-md-5 p-0 d-flex">
                <img src="{{ asset('img/login/login-banner.png') }}"
                     class="img-fluid rounded-start"
                     alt="Login">
            </div>
            <div class="col-md-7">
                <div class="card-body login-body">
                    <div class="text-center mb-4">
                        <h1>Sistema de Gestión de Incidencias Georreferenciadas</h1>
                        <p class="text-muted">
                            Ingrese sus credenciales para acceder
                        </p>
                    </div>
                    <form method="POST" action="{{ route('login.store') }}">
                        @csrf

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">
                                Correo electrónico
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                Contraseña
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Iniciar sesión
                        </button>

                        <div class="text-center mt-3">
                            ¿No tienes una cuenta?
                            <a href="{{ route('register') }}">
                                Registrarse
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection