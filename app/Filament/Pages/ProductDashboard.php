<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ProductChart;
use App\Filament\Widgets\ProductsCategoryChart;
use Filament\Pages\Page;

class ProductDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static string $view = 'filament.pages.product-dashboard';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Estatísticas de Produtos';
    protected static ?string $navigationGroup = 'Relatórios';
    protected static ?string $title = 'Estatísticas de Produtos';
    protected static bool $shouldRegisterNavigation = false;

    protected function getHeaderWidgets(): array
    {
        return [
            ProductsCategoryChart::class,
            ProductChart::class,
        ];
    }

}
