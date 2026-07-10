<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;
use App\Models\Ciudad;
use App\Models\TipoIncidencia;
use App\Models\SubtipoIncidencia;
use App\Models\Estado;
use App\Models\Prioridad;
use App\Models\User;

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
        $ciudades = Ciudad::orderBy('nombre')->get();
        $tipos = TipoIncidencia::orderBy('nombre')->get();
        $subtipos = SubtipoIncidencia::orderBy('nombre')->get();
        $prioridades = Prioridad::orderBy('nombre')->get();

        $ciudadanos = User::whereHas('rol', function ($query) {
            $query->where('nombre', 'Ciudadano');
        })->orderBy('nombres')->get();

        return view('incidencias.create', compact(
            'ciudades',
            'tipos',
            'subtipos',
            'prioridades',
            'ciudadanos'
        ));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ciudadano_id' => 'required|exists:users,id',
            'ciudad_id' => 'required|exists:ciudades,id',
            'tipo_incidencia_id' => 'required|exists:tipos_incidencia,id',
            'subtipo_incidencia_id' => 'required|exists:subtipos_incidencia,id',
            'prioridad_id' => 'required|exists:prioridades,id',
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'evidencia' => 'nullable|array',
            'evidencia.*' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Buscar el estado inicial del flujo
        $estadoRegistrada = Estado::where('nombre', 'Registrada')->first();

        if (!$estadoRegistrada) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'No existe el estado inicial "Registrada".');
        }

        $validated['estado_id'] = $estadoRegistrada->id;

        $incidencia = Incidencia::create($validated);

        if ($request->hasFile('evidencia')) {
            foreach ($request->file('evidencia') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('evidencias', 'public');
                    $incidencia->evidencias()->create([
                        'usuario_id' => $validated['ciudadano_id'],
                        'archivo' => $path,
                        'tipo' => 'imagen',
                        'descripcion' => 'Evidencia cargada al crear la incidencia.',
                    ]);
                }
            }
        }

        return redirect()
            ->route('incidencias.index')
            ->with('success', 'Incidencia registrada correctamente.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Incidencia $incidencia)
    {
         $incidencia->load([
            'ciudadano',
            'ciudad',
            'tipoIncidencia',
            'subtipoIncidencia',
            'estado',
            'prioridad',
            'evidencias',
        ]);

        return view('incidencias.show', compact('incidencia'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incidencia $incidencia)
    {
        $ciudades = Ciudad::orderBy('nombre')->get();
        $tipos = TipoIncidencia::orderBy('nombre')->get();
        $subtipos = SubtipoIncidencia::orderBy('nombre')->get();
        $prioridades = Prioridad::orderBy('nombre')->get();

        $ciudadanos = User::whereHas('rol', function ($query) {
            $query->where('nombre', 'Ciudadano');
        })->orderBy('nombres')->get();

        return view('incidencias.edit', compact(
            'incidencia',
            'ciudades',
            'tipos',
            'subtipos',
            'prioridades',
            'ciudadanos'
        ));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incidencia $incidencia)
    {
        $validated = $request->validate([
            'ciudadano_id' => 'required|exists:users,id',
            'ciudad_id' => 'required|exists:ciudades,id',
            'tipo_incidencia_id' => 'required|exists:tipos_incidencia,id',
            'subtipo_incidencia_id' => 'required|exists:subtipos_incidencia,id',
            'prioridad_id' => 'required|exists:prioridades,id',
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'evidencia' => 'nullable|array',
            'evidencia.*' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);

         $incidencia->update($validated);

        return redirect()
            ->route('incidencias.show', $incidencia->id)
            ->with('success', 'Incidencia actualizada correctamente.');

            return redirect()
                ->route('incidencias.index')
                ->with('success', 'Incidencia actualizada correctamente.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incidencia $incidencia)
    {
        $incidencia->delete();
        return redirect()
            ->route('incidencias.index')
            ->with('success', 'Incidencia eliminada correctamente.');
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
