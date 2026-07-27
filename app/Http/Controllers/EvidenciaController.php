<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Incidencia;

class EvidenciaController extends Controller
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
    public function store(Request $request, $id)
    {
        $request->validate([
            'archivo' => ['required', 'image', 'max:4096'],
            'tipo' => ['required', 'in:antes,despues'],
            'descripcion' => ['nullable', 'string', 'max:500'],
        ]);

        $incidencia = Incidencia::with('asignaciones')->findOrFail($id);

        if ($incidencia->estado->nombre === 'Resuelta') {

            return back()->withErrors([
                'archivo' => 'No puede subir evidencias porque la incidencia ya fue resuelta.'
            ]);

        }

        // Verificar que el usuario tenga asignada la incidencia
        if (!$incidencia->asignaciones()
            ->where('usuario_id', auth()->id())
            ->where('activo', true)
            ->exists()) {

            abort(403);
        }

        $ruta = $request->file('archivo')->store(
            'evidencias',
            'public'
        );

        Evidencia::create([
            'incidencia_id' => $incidencia->id,
            'usuario_id' => auth()->id(),
            'archivo' => $ruta,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Evidencia subida correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evidencia $evidencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evidencia $evidencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evidencia $evidencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evidencia $evidencia)
    {
        $incidenciaId = $evidencia->incidencia_id;

        if ($evidencia->archivo && Storage::disk('public')->exists($evidencia->archivo)) {
            Storage::disk('public')->delete($evidencia->archivo);
        }

        $evidencia->delete();

        return redirect()
            ->route('incidencias.edit', $incidenciaId)
            ->with('success', 'Evidencia eliminada correctamente.');
    }
}
