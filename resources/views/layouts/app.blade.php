<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de incidencias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="d-flex">

    @include('components.sidebar')

    <div class="main-content flex-grow-1">

        @include('components.navbar')

        <main class="p-4">
            @yield('content')
        </main>

    </div>

</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const btnSidebar = document.getElementById('btnSidebar');

            btnSidebar.addEventListener('click', function () {
                document.body.classList.toggle('sidebar-open');
            });

        });
    </script>
</body>
</html>