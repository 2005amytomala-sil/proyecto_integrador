<?php

namespace App\Services;
use App\Models\Incidencia;
use Carbon\Carbon;

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

    /**
     * Obtiene la evolución temporal de incidencias.
     * - <=10 días  : por día
     * - <=31 días  : por semana
     * - >31 días   : por mes
     * - Sin provincia: líneas por provincia
     * - Con provincia: líneas por ciudad
     */
    public function evolucionTemporal($request)
    {
        $incidencias = $this->obtenerIncidenciasFiltradas($request, false);
        if ($incidencias->isEmpty()) {
            return [
                'titulo' => 'Evolución temporal de incidencias',
                'labels' => [],
                'datasets' => []
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Determinar agrupación temporal
        |--------------------------------------------------------------------------
        */

        if (!$request->filled('fecha_inicio') && !$request->filled('fecha_fin')) {
        // Mostrar últimos 6 meses
            $fechaFin = now()->endOfMonth();
            $fechaInicio = now()->subMonths(5)->startOfMonth();
            $tipoAgrupacion = 'mes';
            // También filtramos las incidencias a ese rango
            $incidencias = $incidencias->filter(function ($incidencia) use ($fechaInicio, $fechaFin) {
                return $incidencia->created_at->between($fechaInicio, $fechaFin);
            });
        } else {
            $fechaInicio = $request->fecha_inicio
                ? Carbon::parse($request->fecha_inicio)
                : $incidencias->min('created_at')->copy();
            $fechaFin = $request->fecha_fin
                ? Carbon::parse($request->fecha_fin)
                : now();
            $dias = $fechaInicio->diffInDays($fechaFin) + 1;
            if ($dias <= 10) {
                $tipoAgrupacion = 'dia';
            } elseif ($dias <= 31) {
                $tipoAgrupacion = 'semana';
            } else {
                $tipoAgrupacion = 'mes';
            }
        } 
        /*
        |--------------------------------------------------------------------------
        | Agrupación geográfica
        |--------------------------------------------------------------------------
        */

        if ($request->provincia_id) {

            $series = $incidencias->groupBy(function ($incidencia) {
                return $incidencia->ciudad->nombre;
            });
            $ubicacionTitulo = 'por ciudad';
        } else {
            $series = $incidencias->groupBy(function ($incidencia) {
                return $incidencia->ciudad->provincia->nombre;
            });
            $ubicacionTitulo = 'por provincia';
        }
        // Título según agrupación temporal
        if ($tipoAgrupacion == 'dia') {
            $titulo = 'Evolución diaria de incidencias ' . $ubicacionTitulo;
        } elseif ($tipoAgrupacion == 'semana') {
            $titulo = 'Evolución semanal de incidencias ' . $ubicacionTitulo;
        } else {
            $titulo = 'Evolución mensual de incidencias ' . $ubicacionTitulo;

        }

        /*
        |--------------------------------------------------------------------------
        | Construir eje X
        |--------------------------------------------------------------------------
        */
        $labels = [];
        $claves = [];
        if ($tipoAgrupacion == 'dia') {
            $periodo = $fechaInicio->copy();
            $contador = 1;
            while ($periodo <= $fechaFin) {
                $claves[] = $periodo->format('Y-m-d');
                $labels[] = $periodo->translatedFormat('d M');
                $contador++;
                $periodo->addDay();
            }

        } elseif ($tipoAgrupacion == 'semana') {
            $periodo = $fechaInicio->copy()->startOfWeek();
            $contador = 1;
            while ($periodo <= $fechaFin) {
                $claves[] = [
                    'inicio' => $periodo->copy(),
                    'fin' => $periodo->copy()->endOfWeek(),
                ];
                $labels[] = $periodo->translatedFormat('M') 
                . ' - Semana ' 
                . $contador;
                $contador++;
                $periodo->addWeek();
            }
        } else {
            $periodo = $fechaInicio->copy()->startOfMonth();
            while ($periodo <= $fechaFin) {
                $claves[] = $periodo->format('Y-m');
                $labels[] = $periodo->translatedFormat('M Y');
                $periodo->addMonth();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Construcción de datasets
        |--------------------------------------------------------------------------
        */
        $datasets = [];
        foreach ($series as $nombre => $grupo) {
            $datos = [];
            foreach ($claves as $clave) {
                if ($tipoAgrupacion == 'dia') {
                    $cantidad = $grupo
                        ->where('created_at', '>=', \Carbon\Carbon::parse($clave)->startOfDay())
                        ->where('created_at', '<=', \Carbon\Carbon::parse($clave)->endOfDay())
                        ->count();
                } elseif ($tipoAgrupacion == 'semana') {
                    $cantidad = $grupo
                        ->filter(function ($incidencia) use ($clave) {
                            return $incidencia->created_at->between(
                                $clave['inicio'],
                                $clave['fin']
                            );
                        })
                        ->count();
                } else {
                    $cantidad = $grupo
                        ->filter(function ($incidencia) use ($clave) {
                            return $incidencia->created_at->format('Y-m') == $clave;
                        })
                        ->count();
                }
                $datos[] = $cantidad;
            }
            $datasets[] = [
                'label' => $nombre,
                'data' => $datos
            ];
        }
        return [
            'titulo' => $titulo,
            'labels' => $labels,
            'datasets' => $datasets
        ];
    }

    /**
     * Distribución por prioridad
     */
    public function incidenciasPorPrioridad($request)
    {
        $incidencias = $this->obtenerIncidenciasFiltradas($request, false);


        $datos = $incidencias
            ->groupBy(function ($incidencia) {

                return $incidencia->prioridad->nombre;

            })
            ->map(function ($grupo) {

                return $grupo->count();

            });


        return [

            'titulo' => 'Incidencias por prioridad',

            'labels' => $datos->keys(),

            'data' => $datos->values()

        ];
    }
}
