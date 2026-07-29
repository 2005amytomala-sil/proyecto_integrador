@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-gear"></i> Configuración de la Cuenta</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Tarjeta: Preferencias y Datos Rápidos -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white font-weight-bold">
                    <h5 class="card-title mb-0">Preferencias del Sistema</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('configuracion.updatePerfil') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Número de Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" 
                                   value="{{ old('telefono', $usuario->telefono) }}" placeholder="Ej: 0991234567">
                        </div>

                        <div class="mb-3">
                            <label for="tema_visual" class="form-label">Tema de Interfaz</label>
                            <select name="tema_visual" id="tema_visual" class="form-select">
                                <option value="light" {{ $usuario->tema_visual == 'light' ? 'selected' : '' }}>Claro</option>
                                <option value="dark" {{ $usuario->tema_visual == 'dark' ? 'selected' : '' }}>Oscuro</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="idioma" class="form-label">Idioma</label>
                            <select id="idioma" class="form-select" disabled>
                                <option selected>Español (Ecuador)</option>
                            </select>
                            <small class="text-muted">Por el momento solo está disponible el idioma español.</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar Preferencias</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Cambio de Contraseña -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Cambiar Contraseña</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('configuracion.updatePassword') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" 
                                   name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-warning">Actualizar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection