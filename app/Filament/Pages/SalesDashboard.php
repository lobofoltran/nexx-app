<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SalesDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.sales-dashboard';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Dashboard de Vendas';
    protected static ?string $navigationGroup = 'Relatórios';

}
