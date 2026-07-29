@extends('layouts.guest')

@section('content')

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<div class="login-container">
    <section class="login-image">
        <img 
            src="{{ asset('img/login/login-banner.png') }}"
            alt="Login"
        >
        <div class="login-image-overlay"></div>
        <div class="login-image-text">
            <h1>
                Sistema de Gestión
                de Incidencias
                Georreferenciadas
            </h1>

        </div>

    </section>

    <section class="login-form-container">
        <div class="login-form">
            <div class="login-header">
            <div class="login-icon">
                <i class="bi bi-person-circle"></i>
            </div>
            <h2>Bienvenido</h2>
            <p class="login-subtitle">
                Ingrese sus credenciales para acceder al sistema
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
                <div class="mb-4">
                    <label>
                        Correo electrónico
                    </label>
                    <div class="input-icon">
                        <i class = "bi bi-envelope"></i>
                            <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            required>
                    </div>
                </div>
                <div class="mb-4">
                    <label>
                        Contraseña
                    </label>
                    <div class="input-icon">
                        <i class="bi bi-lock"></i>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required>
                    </div>
                </div>
                <button type="submit" class="btn-login">
                    Iniciar sesión
                </button>
                <div class="register-link">
                    ¿No tienes una cuenta?
                    <a href="{{ route('register') }}">
                        Registrarse
                    </a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection