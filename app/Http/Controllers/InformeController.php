<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\Estado;
use App\Models\Provincia;
use App\Models\TipoIncidencia;
use App\Exports\IncidenciasExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\InformeService;
use Barryvdh\DomPDF\Facade\Pdf;

class InformeController extends Controller
{
    private InformeService $informeService;
    public function __construct(InformeService $informeService)
    {
        $this->informeService = $informeService;
    }

    public function index(Request $request)
    {
        $kpis = $this->obtenerKPIs($request);
        $provincias = Provincia::all();
        $categorias = TipoIncidencia::all();
        $estados = Estado::all();
        $flujoEstados = $this->flujoEstados($request);
        $incidenciasCategoria = $this->incidenciasPorCategoria($request);

        return view('informes.index', compact(
            'kpis',
            'provincias',
            'categorias',
            'estados',
            'flujoEstados',
            'incidenciasCategoria'
        ));
    }

    /**
     * Indicadores pirncipales
     */
    private function obtenerKPIs($request)
    {
        // Respeta fecha, provincia y categoría
        // pero ignora estado
        $incidenciasBase = $this->informeService->obtenerIncidenciasFiltradas($request, false);
        // Respeta todos los filtros incluyendo estado
        $incidencias = $this->informeService->obtenerIncidenciasFiltradas($request, true);
        $total = $incidenciasBase->count();
        $estadoSeleccionado = null;
        if($request->filled('estado_id')){
            $estadoSeleccionado = Estado::find($request->estado_id);
        }
        // Valores por defecto
        $tituloEstado = 'Resueltas';
        $cantidadEstado = $incidenciasBase
            ->filter(function($incidencia){
                return $incidencia->estado->nombre === 'Resuelta';
            })
            ->count();
        $tituloTiempo = 'Tiempo promedio de resolución';
        $tiempoEstado = $this->obtenerTiempoPromedioResolucion(
            $incidenciasBase
        );
        if($estadoSeleccionado){
            switch($estadoSeleccionado->nombre){
                case 'Registrada':
                    $tituloEstado = 'Registradas';
                    $cantidadEstado = $incidencias->count();
                    $tituloTiempo = 'Tiempo promedio esperando validación';
                    $tiempoEstado = $this->obtenerTiempoEsperaValidacion($incidencias);
                    break;
                case 'Validada':
                    $tituloEstado = 'Validadas';
                    $cantidadEstado = $incidencias->count();
                    $tituloTiempo = 'Tiempo promedio esperando atención';
                    $tiempoEstado = $this->obtenerTiempoEsperaProceso($incidencias);
                    break;
                case 'En proceso':
                    $tituloEstado = 'En proceso';
                    $cantidadEstado = $incidencias->count();
                    $tituloTiempo = 'Tiempo promedio en atención';
                    $tiempoEstado = $this->obtenerTiempoEnProceso($incidencias);
                    break;
                case 'Resuelta':
                    $tituloEstado = 'Resueltas';
                    $cantidadEstado = $incidencias->count();
                    $tituloTiempo = 'Tiempo promedio resolución';
                    $tiempoEstado = $this->obtenerTiempoPromedioResolucion($incidencias);
                    break;
                case 'Rechazada':
                    $tituloEstado = 'Rechazadas';
                    $cantidadEstado = $incidencias->count();
                    $tituloTiempo = 'Motivo mas frecuente de rechazo';
                    $tiempoEstado = 'pendiente implementar';
                    break;
                case 'Cancelada':
                    $tituloEstado = 'Canceladas';
                    $cantidadEstado = $incidencias->count();
                    $tituloTiempo = 'Motivo mas frecuente de cancelación';
                    $tiempoEstado = 'Pendiente implementar';
                    break;
            }

        }

        return [

            'total' => $total,
            'titulo_estado' => $tituloEstado,
            'cantidad_estado' => $cantidadEstado,
            'titulo_tiempo' => $tituloTiempo,
            'tiempo_estado' => $tiempoEstado,
            'ubicacion_lider' => $this->obtenerUbicacionLider(
                $incidenciasBase,
                $request
            ),

        ];
    }

    private function obtenerUbicacionLider($incidencias, $request)
    {
        if($incidencias->isEmpty()){
            return [
                'titulo' => 'Ubicación líder',
                'valor' => 'Sin datos'
            ];
        }


        // Si no hay provincia seleccionada
        if(!$request->provincia_id){

            $provincia = $incidencias
                ->groupBy(function($incidencia){
                    return $incidencia->ciudad->provincia->nombre;
                })
                ->sortByDesc(function($grupo){
                    return $grupo->count();
                })
                ->keys()
                ->first();


            return [
                'titulo' => 'Provincia con más incidencias',
                'valor' => $provincia
            ];
        }


        // Si hay provincia seleccionada
        $ciudad = $incidencias
            ->groupBy(function($incidencia){
                return $incidencia->ciudad->nombre;
            })
            ->sortByDesc(function($grupo){
                return $grupo->count();
            })
            ->keys()
            ->first();


        return [
            'titulo' => 'Ciudad con más incidencias',
            'valor' => $ciudad
        ];
    }

    private function obtenerTiempoHastaEstado($incidencias, $estadoFinal)
    {
        $tiempos = [];
        foreach($incidencias as $incidencia){
            $historial = $incidencia->historialEstados
                ->filter(function($item) use ($estadoFinal){
                    return $item->estado->nombre === $estadoFinal;

                })
                ->first();

            if($historial){
                $horas = $incidencia->created_at
                    ->diffInHours($historial->created_at);
                $tiempos[] = $horas / 24;
            }

        }
        if(count($tiempos) == 0){
            return 'Sin datos';
        }
        $promedio = array_sum($tiempos) / count($tiempos);
        $dias = floor($promedio);
        $horas = round(($promedio - $dias) * 24);
        $resultado = "{$dias} días";
        if($horas > 0){
            $resultado .= " y {$horas} horas";
        }
        return $resultado;
    }

    

    /**
     * Evolucion mensual
     */
    private function evolucionMensual($request)
    {
        // Respeta todos los filtros excepto estado
        $incidencias = $this->informeService->obtenerIncidenciasFiltradas($request, false);
        // Agrupar incidencias por mes
        $datos = $incidencias
            ->groupBy(function($incidencia){

                return $incidencia->created_at->format('Y-m');
            })
            ->sortKeys();
        // Etiquetas del eje X
        $labels = $datos->keys()
            ->map(function($fecha){
                return \Carbon\Carbon::parse($fecha)
                    ->translatedFormat('M Y');
            })
            ->values();
        // Cantidad de incidencias por mes
        $valores = $datos
            ->map(function($mes){
                return $mes->count();
            })
            ->values();
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Incidencias registradas',
                    'data' => $valores
                ]
            ]
        ];
    }

    /**
     * Incidencias por categoria
     */
    private function incidenciasPorCategoria($request)
    {
        // Respeta filtros excepto estado
        $incidencias = $this->informeService->obtenerIncidenciasFiltradas($request, false);
        // Si hay categoría seleccionada mostramos subtipos
        if($request->categoria_id){
            $datos = $incidencias
                ->groupBy(function($incidencia){
                    return $incidencia->subtipoIncidencia->nombre;
                });
            $titulo = 'Distribución de subtipos segun la categoria';
        }else{
            $datos = $incidencias
                ->groupBy(function($incidencia){
                    return $incidencia->tipoIncidencia->nombre;
                });
            $titulo = 'Distribución de categorías';
        }
        $total = $datos->sum(function($grupo){
            return $grupo->count();
        });
        $labels = [];
        $valores = [];
        foreach($datos as $nombre => $grupo){
            $labels[] = $nombre;
            $porcentaje = ($grupo->count() / $total) * 100;
            $valores[] = round($porcentaje,2);
        }
        return [
            'titulo' => $titulo,
            'labels'=>$labels,
            'data'=>$valores
        ];
    }

    /**
     * Incidencias por ciudad
     */
    private function incidenciasPorCiudad($request)
    {

    }

    /**
     * Tiempo promedio de resolucion
     */
    private function tiempoPromedio($request)
    {

    }

    private function obtenerTiempoPromedioResolucion($incidencias)
    {
        $tiempos = [];

        foreach($incidencias as $incidencia){
            if($incidencia->estado->nombre !== 'Resuelta'){
                continue;
            }

            $inicio = $incidencia->historialEstados
                ->filter(function($historial){
                    return $historial->estado->nombre === 'Validada';
                })
                ->first();

            if($inicio){
                $horas = $inicio->created_at
                    ->diffInHours($incidencia->fecha_resolucion);
                $tiempos[] = $horas / 24;
            }

        }
        if(count($tiempos) == 0){
            return 'Sin datos';
        }
        $promedio = array_sum($tiempos) / count($tiempos);
        $dias = floor($promedio);
        $horas = round(($promedio - $dias) * 24);
        $resultado = "{$dias} días";

        if($horas > 0){
            $resultado .= " y {$horas} horas";
        }
        return $resultado;
    }

    private function formatearTiempo($diasDecimal)
    {
        $dias = floor($diasDecimal);
        $horas = round(($diasDecimal - $dias) * 24);
        $resultado = "{$dias} días";

        if($horas > 0){
            $resultado .= " y {$horas} horas";
        }
        return $resultado;
    }
    
    private function obtenerTiempoEsperaValidacion($incidencias){
        $tiempos = [];
        foreach($incidencias as $incidencia){
            $horas = $incidencia->created_at
                ->diffInHours(now());
            $tiempos[] = $horas / 24;
        }
        if(count($tiempos)==0){
            return 'Sin datos';
        }
        return $this->formatearTiempo(
            array_sum($tiempos)/count($tiempos)
        );
    }

    private function obtenerTiempoEsperaProceso($incidencias){
        $tiempos = [];
        foreach($incidencias as $incidencia){
            $inicio = $incidencia->historialEstados
                ->firstWhere('estado.nombre','Validada');
            if($inicio){
                $horas = $inicio->created_at
                    ->diffInHours(now());
                $tiempos[] = $horas/24;
            }
        }
        if(count($tiempos)==0){
            return 'Sin datos';
        }

        return $this->formatearTiempo(
            array_sum($tiempos)/count($tiempos)
        );
    }

    private function obtenerTiempoEnProceso($incidencias){
        $tiempos = [];
        foreach($incidencias as $incidencia){
            $inicio = $incidencia->historialEstados
                ->firstWhere('estado.nombre','En proceso');
            if($inicio){
                $horas = $inicio->created_at
                    ->diffInHours(now());
                $tiempos[] = $horas/24;
            }
        }
        if(count($tiempos)==0){
            return 'Sin datos';
        }
        return $this->formatearTiempo(
            array_sum($tiempos)/count($tiempos)
        );
    }

    private function obtenerCiudadLider($incidencias)
    {
        if ($incidencias->isEmpty()) {
            return 'Sin datos';
        }

        $ciudad = $incidencias
            ->groupBy(function ($incidencia) {
                return $incidencia->ciudad->nombre;
            })
            ->sortByDesc(function ($grupo) {
                return $grupo->count();
            })
            ->keys()
            ->first();

        return $ciudad ?? 'Sin datos';
    }

    private function flujoEstados($request)
    {
        // Ignoramos el filtro de estado porque queremos ver todos
        $incidencias = $this->informeService->obtenerIncidenciasFiltradas($request, false);

        $estados = $incidencias
            ->groupBy(function($incidencia){
                return $incidencia->estado->nombre;
            })
            ->map(function($grupo){
                return $grupo->count();
            });

        return [
            'labels' => $estados->keys(),
            'data' => $estados->values(),
        ];
    }


    public function exportarExcel(Request $request)
    {
        return Excel::download(
            new IncidenciasExport($request),
            'Informe_Incidencias_' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function exportarPDF(Request $request)
    {
        $incidencias = $this->informeService
            ->obtenerIncidenciasFiltradas($request, true);

        $kpis = $this->obtenerKPIs($request);

        $pdf = Pdf::loadView(
            'informes.pdf',
            compact(
                'incidencias',
                'kpis',
                'request'
            )
        );

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download(
            'Informe_Incidencias_'
            . now()->format('Y-m-d')
            . '.pdf'
        );
    }
}
