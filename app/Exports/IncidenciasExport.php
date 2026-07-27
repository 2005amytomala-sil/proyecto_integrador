<?php

namespace App\Exports;

use App\Models\Incidencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class IncidenciasExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Incidencia::with([
            'estado',
            'ciudad.provincia',
            'tipoIncidencia',
            'subtipoIncidencia',
            'prioridad'
        ]);

        if ($this->request->fecha_inicio) {
            $query->whereDate(
                'created_at',
                '>=',
                $this->request->fecha_inicio
            );
        }

        if ($this->request->fecha_fin) {
            $query->whereDate(
                'created_at',
                '<=',
                $this->request->fecha_fin
            );
        }

        if ($this->request->provincia_id) {
            $query->whereHas('ciudad', function ($q) {
                $q->where(
                    'provincia_id',
                    $this->request->provincia_id
                );
            });
        }

        if ($this->request->categoria_id) {
            $query->where(
                'tipo_incidencia_id',
                $this->request->categoria_id
            );
        }

        if ($this->request->estado_id) {
            $query->where(
                'estado_id',
                $this->request->estado_id
            );
        }

        return $query->orderBy('id', 'asc')->get()->map(function ($incidencia) {

            return [

                $incidencia->id,
                $incidencia->created_at->format('d/m/Y H:i'),
                $incidencia->titulo,
                $incidencia->ciudad->provincia->nombre,
                $incidencia->ciudad->nombre,
                $incidencia->tipoIncidencia->nombre,
                $incidencia->subtipoIncidencia->nombre ?? '-',
                $incidencia->descripcion,
                $incidencia->estado->nombre,
                $incidencia->prioridad->nombre,

            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'Título',
            'Provincia',
            'Ciudad',
            'Categoría',
            'Subcategoría',
            'Descripcion',
            'Estado',
            'Prioridad'
        ];
    }

    
    public function styles(Worksheet $sheet)
    {
        // Encabezados
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF',
                ],
                'size' => 12,
            ],

            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '1F4E78',
                ],
            ],

            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],

            // Bordes blancos entre encabezados
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'rgb' => 'FFFFFF',
                    ],
                ],
            ],
        ]);

        // Bordes de toda la tabla
        $ultimaFila = $sheet->getHighestRow();

        $sheet->getStyle("A1:J{$ultimaFila}")
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => [
                            'rgb' => 'D9D9D9',
                        ],
                    ],
                ],
            ]);

        $sheet->getStyle("A1:J{$ultimaFila}")
        ->getAlignment()
        ->setWrapText(true);

        // Altura del encabezado
        $sheet->getRowDimension(1)->setRowHeight(25);

        $sheet->getColumnDimension('C')->setWidth(35);

        $sheet->getColumnDimension('H')->setWidth(50);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // Congelar la primera fila
                $sheet->freezePane('A2');

                // Activar filtros
                $sheet->setAutoFilter('A1:J1');
            },
        ];
    }
}
