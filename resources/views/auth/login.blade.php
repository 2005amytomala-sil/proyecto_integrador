<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Incidencias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    @vite(['resources/css/auth.css'])
</head>
<body>

    <div class="container login-container">
    <div class="card card-login mb-3 shadow-lg">
        <div class="row g-0 ">
            <div class="col-md-5 p-0 d-flex">
            <img clas src="{{ asset('img/login/login-banner.png') }}" class="img-fluid rounded-start" alt="..." >
            </div>
            <div class="col-md-7">
            <div class="card-body login-body">
                <div class="text-center mb-4">
                <h1> Sistema de Gestión de Incidencias Georreferenciadas</h1>
                <p class="text-muted">Ingrese sus credenciales para acceder</p>
            </div>
            <form>
                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control">
                </div>
                <div class="mb-4">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-control">   
                </div>
                <button class="btn btn-primary w-100">Iniciar sesión</button>
                <div class="text-center mt-3">
                    ¿No tienes una cuenta?
                    <a href="{{ route('register') }}">Registrarse</a>
                </div>
            </form>
            </div>
            </div>
        </div>
    </div>



</body>
</html>