<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Incidencias</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS propio -->
    @vite('resources/css/auth.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<div class="container vh-100 d-flex justify-content-center align-items-center">

    <div class="card shadow-lg p-4 login-card">

        <div class="text-center mb-4">
            <i class="bi bi-shield-lock-fill display-3 text-primary"></i>

            <h2 class="mt-3">
                Sistema de Incidencias
            </h2>

            <p class="text-muted">
                Inicie sesión para continuar
            </p>
        </div>

        <form>

            <div class="mb-3">
                <label class="form-label">
                    Correo electrónico
                </label>

                <input
                    type="email"
                    class="form-control"
                    placeholder="correo@empresa.com">
            </div>

            <div class="mb-4">
                <label class="form-label">
                    Contraseña
                </label>

                <input
                    type="password"
                    class="form-control"
                    placeholder="********">
            </div>

            <button class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right"></i>
                Ingresar
            </button>

        </form>

    </div>

</div>

</body>
</html>