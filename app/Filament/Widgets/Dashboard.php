<?php

namespace App\Filament\Widgets;

use App\Models\Categoria;
use App\Models\Movimiento;
use App\Models\Persona;
use App\Models\Prestamo;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Dashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $totalIngresos = Movimiento::whereHas('categoria', fn ($query) =>
            $query->where('tipo', 'ingreso')
        )->sum('monto');

        $totalGastos = Movimiento::whereHas('categoria', fn ($query) =>
            $query->where('tipo', 'gasto')
        )->sum('monto');

        $balance = $totalIngresos - $totalGastos;

        return [
            Stat::make('📊 Saldo Actual', number_format($balance, 2) . ' Bs')
                ->description('Monto actual de saldo')
                ->icon('heroicon-o-wallet')
                ->chart([1,4,2,6,3,8,4,10])
                ->color($balance >= 0 ? 'success' : 'danger'),

            Stat::make('💸 Ingresos Totales', number_format($totalIngresos, 2) . ' Bs')
                ->description('Ingresos que se han recibido')
                ->icon('heroicon-o-arrow-trending-up')
                ->chart([1,4,2,6,3,8,4,10])
                ->color('warning'),

            Stat::make('💰 Gastos Totales', number_format($totalGastos, 2) . ' Bs')
                ->description('Gastos que se han realizado')
                ->icon('heroicon-o-arrow-trending-down')
                ->chart([10,4,8,2,1,3,2,1])
                ->color('danger'),

        ];
    }
}
