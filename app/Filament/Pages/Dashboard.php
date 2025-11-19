<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\Dashboard as DashboardWidget;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?int $navigationSort = 1;

    protected function getHeaderWidgets(): array
    {
        return [
            DashboardWidget::class,
        ];
    }
}