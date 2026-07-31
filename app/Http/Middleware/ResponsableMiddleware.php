<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ResponsableMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $rol = trim(auth()->user()->rol->nombre);

        if ($rol !== 'Responsable') {
            abort(403, 'No tiene permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}