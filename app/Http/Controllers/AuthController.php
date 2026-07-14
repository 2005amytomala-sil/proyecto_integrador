<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'activo' => true,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        $usuario = User::where('email', $request->email)->first();

        if ($usuario && !$usuario->activo) {

            return back()->withErrors([
                'email' => 'Su cuenta ha sido desactivada. Contacte al administrador.',
            ]);

        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ]);
        
    }

    public function register(RegisterRequest $request)
    {
        $datos = $request->validated();

        $rolCiudadano = Rol::where('nombre', 'Ciudadano')->first();

        User::create([
            'rol_id' => $rolCiudadano->id,
            'ciudad_id' => $datos['ciudad_id'],
            'cedula' => $datos['cedula'],
            'nombres' => $datos['nombres'],
            'apellidos' => $datos['apellidos'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'] ?? null,
            'direccion' => $datos['direccion'] ?? null,
            'password' => Hash::make($datos['password']),
            'activo' => true,
        ]);

        return redirect()->route('login')->with('success', 'Registro realizado correctamente.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
