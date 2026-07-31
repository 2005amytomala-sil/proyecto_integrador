<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOperadorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $rol = auth()->user()->rol->nombre;

        if (!in_array($rol, ['Administrador', 'Operador'])) {
            abort(403, 'No tiene permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}