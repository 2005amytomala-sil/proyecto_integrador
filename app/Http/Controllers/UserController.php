<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use App\Models\Pais;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::with(['rol', 'ciudad'])
        ->orderBy('id')
        ->get();

        return view('users.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Rol::orderBy('nombre')->get();
        $paises = Pais::orderBy('nombre')->get();

        return view('users.create', compact('roles', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $datos = $request->validated();

        User::create([
            'rol_id'      => $datos['rol_id'],
            'ciudad_id'   => $datos['ciudad_id'],
            'cedula'      => $datos['cedula'],
            'nombres'     => $datos['nombres'],
            'apellidos'   => $datos['apellidos'],
            'email'       => $datos['email'],
            'telefono'    => $datos['telefono'] ?? null,
            'direccion'   => $datos['direccion'] ?? null,
            'password'    => bcrypt($datos['password']),
            'activo'      => true,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Rol::orderBy('nombre')->get();
        $paises = Pais::orderBy('nombre')->get();

        return view('users.edit', compact(
            'user',
            'roles',
            'paises'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $datos = $request->validated();

        $user->rol_id = $datos['rol_id'];
        $user->ciudad_id = $datos['ciudad_id'];
        $user->cedula = $datos['cedula'];
        $user->nombres = $datos['nombres'];
        $user->apellidos = $datos['apellidos'];
        $user->email = $datos['email'];
        $user->telefono = $datos['telefono'] ?? null;
        $user->direccion = $datos['direccion'] ?? null;

        if (!empty($datos['password'])) {
            $user->password = bcrypt($datos['password']);
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Evitar que un administrador cambie su propio estado
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('users.index')
                ->with('error', 'No puede cambiar el estado de su propio usuario.');
        }

        $user->activo = !$user->activo;

        $user->save();

        $mensaje = $user->activo
            ? 'Usuario activado correctamente.'
            : 'Usuario desactivado correctamente.';

        return redirect()
            ->route('users.index')
            ->with('success', $mensaje);
    }
}
