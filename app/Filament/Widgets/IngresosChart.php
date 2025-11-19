<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use Filament\Widgets\ChartWidget;

class IngresosChart extends ChartWidget
{
    protected static ?string $heading = 'Reporte de Ingresos y Gastos';

    protected function getData(): array
    {
        // Lista de todos los meses en español
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                  'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];


        // Inicializar arrays vacíos
        $ingresosPorMes = array_fill(0, 12, 0);
        $gastosPorMes = array_fill(0, 12, 0);


        // Obtener ingresos agrupados por mes (1 a 12)
        $ingresos = Movimiento::selectRaw('EXTRACT(MONTH FROM fecha) as mes, SUM(monto) as total')
            ->whereHas('categoria', fn ($query) =>
                $query->where('tipo', 'ingreso')
            )
            ->groupBy('mes')
            ->get();

        foreach ($ingresos as $item) {
            $ingresosPorMes[$item->mes - 1] = $item->total;
        }

        // Gastos
        $gastos = Movimiento::selectRaw('EXTRACT(MONTH FROM fecha) as mes, SUM(monto) as total')
            ->whereHas('categoria', fn ($query) =>
                $query->where('tipo', 'gasto')
            )
            ->groupBy('mes')
            ->get();
            
        foreach ($gastos as $item) {
            $gastosPorMes[$item->mes - 1] = $item->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ingresos',
                    'data' => $ingresosPorMes,
                    'borderColor' => '#22c55e',
                    'backgroundColor' => '#22c55e',
                    'fill' => false,
                ],
                [
                    'label' => 'Gastos',
                    'data' => $gastosPorMes,
                    'borderColor' => '#ef4444',
                    'backgroundColor' => '#ef4444',
                    'fill' => false,
                ],
            ],
            'labels' => $meses,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
