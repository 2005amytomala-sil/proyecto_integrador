<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error del Servidor - 500</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-teal-50 via-emerald-50 to-cyan-50 min-h-screen flex items-center justify-center p-4 antialiased">

    <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-8 max-w-md w-full text-center border border-teal-100/60 shadow-lg shadow-teal-900/5 transition-all duration-300 hover:shadow-xl hover:shadow-teal-900/10">
        
        <div class="mx-auto mb-6 w-16 h-16 bg-teal-100/80 text-teal-600 rounded-full flex items-center justify-center">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
        </div>
        
        <span class="inline-block px-3 py-1 bg-teal-50 text-teal-700 text-xs font-semibold tracking-wide uppercase rounded-full mb-3 border border-teal-100">
            Error 500
        </span>
        
        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            Algo Salió Mal
        </h1>
        
        <p class="text-gray-500 text-sm leading-relaxed mb-8">
            {{ $exception->getMessage() ?: 'Ocurrió un problema inesperado en nuestros servidores. Ya estamos trabajando para solucionarlo.' }}
        </p>
        
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center justify-center w-full bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white font-medium py-3 px-6 rounded-xl shadow-md shadow-teal-500/20 hover:shadow-lg hover:shadow-teal-500/30 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Reintentar / Ir al Inicio
        </a>

    </div>

</body>
</html>