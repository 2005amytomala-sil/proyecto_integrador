<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return Incidencia::with([
                'ciudadano',
                'ciudad',
                'tipoIncidencia',
                'subtipoIncidencia',
                'estado',
                'prioridad',
            ])->get();
        }

        return view('incidencias.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retornará el formulario de creación de incidencias.
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $incidencia = Incidencia::create($request->all());
        return response()->json($incidencia, 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(Incidencia $incidencia)
    {
        return $incidencia;
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incidencia $incidencia)
    {
        // Retornará el formulario de edición de incidencias.
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incidencia $incidencia)
    {
        $incidencia->update($request->all());
        return response()->json($incidencia);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incidencia $incidencia)
    {
        $incidencia->delete();
        return response()->json([
            'mensaje' => 'Incidencia eliminada correctamente'
        ]);
    }

    public function apiIndex()
    {
        $incidencias = \App\Models\Incidencia::with([
            'ciudadano',
            'ciudad',
            'tipoIncidencia',
            'subtipoIncidencia',
            'estado',
            'prioridad'
        ])->get();

        return response()->json($incidencias);
    }
}
