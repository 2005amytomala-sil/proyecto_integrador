<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Comentario;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Incidencia $incidencia)
    {
        $usuario = Auth::user();
        $rol = $usuario->rol->nombre;

        $esCiudadanoCreador = ($rol === 'Ciudadano' && $incidencia->ciudadano_id === $usuario->id);
        
        $esResponsableAsignado = $incidencia->asignaciones()
            ->where('usuario_id', $usuario->id)
            ->exists();

        if (!$esCiudadanoCreador && !$esResponsableAsignado && $rol !== 'Administrador') {
            return back()->with('error', 'No tienes permiso para comentar en esta incidencia.');
        }

        $validated = $request->validate([
            'contenido' => 'required|string|max:1000',
        ]);

        DB::transaction(function () use ($validated, $incidencia, $usuario) {
            //Crear el Comentario
            $incidencia->comentarios()->create([
                'usuario_id' => $usuario->id,
                'contenido'  => $validated['contenido'],
                
            ]);

            $asignadosIds = $incidencia->asignaciones()->pluck('usuario_id')->toArray();

            $involucrados = array_unique(array_merge([$incidencia->ciudadano_id], $asignadosIds));

            $destinatariosIds = array_filter($involucrados, function ($id) use ($usuario) {
                return $id && $id != $usuario->id;
            });

            //Enviar Notificación a los destinatarios elegibles
            foreach ($destinatariosIds as $destinatarioId) {
                Notificacion::create([
                    'usuario_id'    => $destinatarioId,
                    'incidencia_id' => $incidencia->id,
                    'titulo'        => 'Nuevo comentario en Incidencia #' . $incidencia->id,
                    'mensaje'       => "{$usuario->nombres} comentó: \"" . \Illuminate\Support\Str::limit($validated['contenido'], 40) . "\"",
                    'leida'         => false,
                ]);
            }
        });

        return back()->with('success', 'Comentario publicado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comentario $comentario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comentario $comentario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comentario $comentario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comentario $comentario)
    {
        //
    }
}
