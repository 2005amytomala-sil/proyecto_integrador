<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ConfiguracionController extends Controller
{
    /**
     * Muestra la vista de configuración del usuario.
     */
    public function miConfiguracion()
    {
        $usuario = Auth::user();
        return view('configuracion.index', compact('usuario'));
    }

    /**
     * Actualiza la información del perfil y preferencias.
     */
    public function updatePerfil(Request $request)
    {
        $usuario = Auth::user();

        $request->validate([
            'telefono'        => 'nullable|string|max:15',
        ]);

        $usuario->update([
            'telefono'        => $request->telefono,
        ]);

        return back()->with('success', 'Configuración actualizada correctamente.');
    }

    /**
     * Actualiza la contraseña del usuario.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}