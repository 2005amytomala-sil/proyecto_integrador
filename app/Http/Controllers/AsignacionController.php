<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Asignacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Estado;
use App\Models\Incidencia;

class AsignacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estadoValidada = Estado::where('nombre', 'Validada')->first();
        $estadoEnProceso = Estado::where('nombre', 'En proceso')->first();

        $pendientes = Incidencia::with([
                'tipoIncidencia',
                'estado',
                'responsablePrincipal.usuario'
            ])
            ->where('estado_id', $estadoValidada->id)
            ->whereDoesntHave('responsablePrincipal')
            ->latest()
            ->get();

        $asignadas = Incidencia::with([
                'tipoIncidencia',
                'estado',
                'responsablePrincipal.usuario'
            ])
            ->where('estado_id', $estadoEnProceso->id)
            ->whereHas('responsablePrincipal')
            ->latest()
            ->get();

        return view('asignaciones.index', compact(
            'pendientes',
            'asignadas'
        ));
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
            'responsable_id' => ['required', 'exists:users,id'],
            'apoyos' => ['nullable', 'array'],
            'apoyos.*' => ['exists:users,id'],
            'observacion' => ['nullable', 'string'],
        ]);

        // Evitar que el responsable también sea apoyo
        $apoyos = collect($request->apoyos ?? []);

        if ($apoyos->contains($request->responsable_id)) {
            return back()
                ->withInput()
                ->withErrors([
                    'responsable_id' => 'El responsable principal no puede ser también personal de apoyo.'
                ]);
        }

        $incidencia = Incidencia::findOrFail($id);

        $estadoEnProceso = Estado::where('nombre', 'En proceso')->firstOrFail();

        //Impide que haya mas de un responsable principal
        if ($incidencia->responsablePrincipal()->exists()) {
            return back()->withErrors([
                'responsable_id' => 'Esta incidencia ya tiene un responsable asignado.'
            ]);
        }

        DB::transaction(function () use ($request, $incidencia, $estadoEnProceso) {

            // Responsable principal
            Asignacion::create([
                'incidencia_id'   => $incidencia->id,
                'usuario_id'      => $request->responsable_id,
                'operador_id'     => auth()->id(),
                'tipo_asignacion' => 'responsable',
                'observacion'     => $request->observacion,
                'activo'          => true,
            ]);

            // Personal de apoyo
            foreach ($request->apoyos ?? [] as $usuarioId) {

                Asignacion::create([
                    'incidencia_id'   => $incidencia->id,
                    'usuario_id'      => $usuarioId,
                    'operador_id'     => auth()->id(),
                    'tipo_asignacion' => 'apoyo',
                    'activo'          => true,
                ]);

            }

            // Cambiar estado de la incidencia
            $incidencia->update([
                'estado_id' => $estadoEnProceso->id,
            ]);

        });

        return redirect()
            ->route('asignaciones.index')
            ->with('success', 'Asignación realizada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    /*
    public function show($id)
    {
        $incidencia = Incidencia::findOrFail($id);

        dd($incidencia->getAttributes());
    }
    */
    public function show($id)
    {
            $incidencia = Incidencia::with([
            'ciudadano',
            'ciudad',
            'tipoIncidencia',
            'subtipoIncidencia',
            'estado',
            'prioridad',
            'comentarios.usuario',
            'responsablePrincipal.usuario',
            'apoyos.usuario',
        ])->findOrFail($id);

        $trabajadores = User::whereHas('rol', function ($query) {
            $query->where('nombre', 'Responsable');
        })
        ->where('activo', true)
        ->orderBy('nombres')
        ->get();

        return view('asignaciones.show', compact(
            'incidencia',
            'trabajadores'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asignacion $asignacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asignacion $asignacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asignacion $asignacion)
    {
        //
    }

    public function misAsignaciones()
    {
        $incidencias = Incidencia::with([
            'estado',
            'prioridad',
            'tipoIncidencia',
            'responsablePrincipal.usuario'
        ])
        ->whereHas('asignaciones', function ($query) {
            $query->where('usuario_id', auth()->id())
                ->where('activo', true);
        })
        ->orderByDesc('created_at')
        ->get();

        return view('asignaciones.mis-asignaciones', compact('incidencias'));
    }
    public function showResponsable($id)
    {
        $incidencia = Incidencia::with([
            'ciudadano',
            'ciudad',
            'tipoIncidencia',
            'subtipoIncidencia',
            'estado',
            'prioridad',
            'comentarios.usuario',
            'responsablePrincipal.usuario',
            'responsablePrincipal.operador',
            'apoyos.usuario',
            'evidenciasAntes',
            'evidenciasDespues',
        ])->findOrFail($id);

        // Verificar que el responsable tenga asignada esta incidencia
        if (!$incidencia->asignaciones()
            ->where('usuario_id', auth()->id())
            ->where('activo', true)
            ->exists()) {

            abort(403, 'No tiene permiso para ver esta incidencia.');
        }

        return view('asignaciones.show-responsable', compact('incidencia'));
    }

}