<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<style>
{!! file_get_contents(resource_path('css/pdf.css')) !!}
</style>

</head>

    <body>


    <div class="header">

        <div class="titulo">
            Informe de Incidencias
        </div>

        <div class="subtitulo">
            Sistema de Gestión de Incidencias Georreferenciadas
        </div>

        <br>

        <div>
            Fecha de generación:
            {{ now()->format('d/m/Y H:i') }}
        </div>

    </div>

    <h2>Criterios del Informe</h2>

    <table class="criterios">

        <tr>
            <td>Periodo</td>
            <td>
                {{ $request->fecha_inicio 
                    ? \Carbon\Carbon::parse($request->fecha_inicio)->format('d/m/Y')
                    : 'Sin especificar'
                }}

                -
                
                {{ $request->fecha_fin 
                    ? \Carbon\Carbon::parse($request->fecha_fin)->format('d/m/Y')
                    : 'Sin especificar'
                }}
            </td>
        </tr>


        <tr>
            <td>Provincia</td>
            <td>
                @if($request->provincia_id)

                    {{ \App\Models\Provincia::find($request->provincia_id)->nombre }}

                @else

                    Todas

                @endif
            </td>
        </tr>


        <tr>
            <td>Categoría</td>
            <td>
                @if($request->categoria_id)

                    {{ \App\Models\TipoIncidencia::find($request->categoria_id)->nombre }}

                @else

                    Todas

                @endif
            </td>
        </tr>


        <tr>
            <td>Estado</td>
            <td>
                @if($request->estado_id)

                    {{ \App\Models\Estado::find($request->estado_id)->nombre }}

                @else

                    Todos

                @endif
            </td>
        </tr>

    </table>



    <div class="seccion">
    Resumen General
    </div>


    <table class="kpi-table">

    <tr>
        <td>Total de incidencias</td>
        <td>
            {{ $kpis['total'] }}
        </td>
    </tr>


    <tr>
        <td>
            {{ $kpis['titulo_estado'] }}
        </td>

        <td>
            {{ $kpis['cantidad_estado'] }}
        </td>
    </tr>


    <tr>

    <td>
    {{ $kpis['titulo_tiempo'] }}
    </td>

    <td>
    {{ $kpis['tiempo_estado'] }}
    </td>

    </tr>

    <tr>
        <td>{{ $kpis['ubicacion_lider']['titulo'] }}</td>

        <td>
            {{ $kpis['ubicacion_lider']['valor'] }}
        </td>
    </tr>


    </table>



    <div class="seccion">
    Detalle de incidencias
    </div>


    <table class="tabla-incidencias">

    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Título</th>
            <th>Provincia</th>
            <th>Ciudad</th>
            <th>Estado</th>
            <th>Prioridad</th>
        </tr>
    </thead>


    <tbody>

        @foreach($incidencias as $incidencia)

        <tr>

            <td>
                {{ $incidencia->id }}
            </td>

            <td>
                {{ $incidencia->created_at->format('d/m/Y') }}
            </td>

            <td>
                {{ $incidencia->titulo }}
            </td>

            <td>
                {{ $incidencia->ciudad->provincia->nombre }}
            </td>

            <td>
                {{ $incidencia->ciudad->nombre }}
            </td>

            <td>
                {{ $incidencia->estado->nombre }}
            </td>

            <td>
                {{ $incidencia->prioridad->nombre }}
            </td>

        </tr>

        @endforeach

    </tbody>

</table>



    <div class="footer">

        Sistema de Gestión de Incidencias Georreferenciadas |
        Informe generado automáticamente |

    </div>


    </body>
</html>