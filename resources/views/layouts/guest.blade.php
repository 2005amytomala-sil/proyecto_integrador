<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Incidencias</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite([
        'resources/css/auth.css',
        'resources/js/app.js'
    ])
</head>
<body>

    @yield('content')

    @stack('scripts')

</body>
</html>