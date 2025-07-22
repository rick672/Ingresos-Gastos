<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use Filament\Widgets\ChartWidget;

class GastosChart extends ChartWidget
{
   protected static ?string $heading = 'Distribución de Gastos por Categoría';

    protected function getData(): array
    {
        $data = Movimiento::selectRaw('categorias.nombre, SUM(movimientos.monto) as total')
            ->join('categorias', 'movimientos.categoria_id', '=', 'categorias.id')
            ->where('categorias.tipo', 'gasto')
            ->groupBy('categorias.nombre')
            ->orderByDesc('total')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Gastos por categoría',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => [
                        '#ef4444', '#f97316', '#eab308', '#22c55e',
                        '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6',
                    ],
                    'borderColor' => [
                        '#ef4444', '#f97316', '#eab308', '#22c55e',
                        '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6',
                    ]
                ],
            ],
            'labels' => $data->pluck('nombre'),
        ];
    }
    protected function getType(): string
    {
        return 'bar';
    }
}
