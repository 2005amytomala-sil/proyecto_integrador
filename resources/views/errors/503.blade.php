<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>En Mantenimiento - 503</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-teal-50 via-emerald-50 to-cyan-50 min-h-screen flex items-center justify-center p-4 antialiased">

    <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-8 max-w-md w-full text-center border border-teal-100/60 shadow-lg shadow-teal-900/5 transition-all duration-300 hover:shadow-xl hover:shadow-teal-900/10">
        
        <div class="mx-auto mb-6 w-16 h-16 bg-teal-100/80 text-teal-600 rounded-full flex items-center justify-center">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <span class="inline-block px-3 py-1 bg-teal-50 text-teal-700 text-xs font-semibold tracking-wide uppercase rounded-full mb-3 border border-teal-100">
            Estado 503
        </span>
        
        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            Estamos en Mantenimiento
        </h1>
        
        <p class="text-gray-500 text-sm leading-relaxed mb-8">
            {{ $exception->getMessage() ?: 'Estamos realizando mejoras en la plataforma. Regresaremos en unos minutos.' }}
        </p>
        
        <button onclick="window.location.reload()" 
                class="inline-flex items-center justify-center w-full bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white font-medium py-3 px-6 rounded-xl shadow-md shadow-teal-500/20 hover:shadow-lg hover:shadow-teal-500/30 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Recargar Página
        </button>

    </div>

</body>
</html>