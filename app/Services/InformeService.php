<?php

namespace App\Services;
use App\Models\Incidencia;

class InformeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Obtiene las incidencias filtradas por los parametros del request
     */
    public function obtenerIncidenciasFiltradas($request, $filtrarEstado = true)
    {
        $query = Incidencia::with([
            'estado',
            'ciudad.provincia',
            'tipoIncidencia',
            'historialEstados.estado'
        ]);
        // Filtro por fecha inicio
        if($request->fecha_inicio){
            $query->whereDate(
                'created_at',
                '>=',
                $request->fecha_inicio
            );
        }
        // Filtro por fecha fin
        if($request->fecha_fin){
            $query->whereDate(
                'created_at',
                '<=',
                $request->fecha_fin
            );
        }
        // Filtro por provincia
        if($request->provincia_id){
            $query->whereHas('ciudad', function($q) use ($request){
                $q->where(
                    'provincia_id',
                    $request->provincia_id
                );
            });
        }
        // Filtro por estado
        if($filtrarEstado && $request->estado_id){
            $query->where(
                'estado_id',
                $request->estado_id
            );
        }
        // Filtro por categoría
        if($request->categoria_id){
            $query->where(
                'tipo_incidencia_id',
                $request->categoria_id
            );
        }
        return $query
            ->orderBy('id', 'asc')
            ->get();
    }
}
