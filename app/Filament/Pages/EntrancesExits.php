<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\PaymentStats;
use App\Filament\Widgets\ProductsCategoryChart;
use Filament\Pages\Page;

class EntrancesExits extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';
    protected static string $view = 'filament.pages.entrances-exits';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Estatísticas de Entradas';
    protected static ?string $navigationGroup = 'Relatórios';
    protected static ?string $title = 'Estatísticas de Entradas';
    protected static bool $shouldRegisterNavigation = false;

    protected function getHeaderWidgets(): array
    {
        return [
            PaymentStats::class,
            ProductsCategoryChart::class,
            
        ];
    }

}
