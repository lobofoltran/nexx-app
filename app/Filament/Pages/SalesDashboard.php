<?php

namespace App\Filament\Pages;

use App\Filament\Resources\ProductResource;
use App\Filament\Widgets\InvoicingChart;
use App\Filament\Widgets\InvoicingStats;
use App\Filament\Widgets\LatestSales;
use Filament\Actions\Action;
use Filament\Actions\SelectAction;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Widgets;

class SalesDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.sales-dashboard';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Estatísticas de Vendas';
    protected static ?string $navigationGroup = 'Relatórios';
    protected static ?string $title = 'Estatísticas de Vendas (Mês atual)';
    public $filter = 'month';

    public function getHeaderActions(): array
    {
        return [
            // Action::make('Alterar Data')
            //     ->label('Alterar data')
            //     ->form([
            //         Select::make('filter')
            //             ->label('Data')
            //             ->options(['month' => 'Mês atual', 'lastMonth' => 'Último mês'])
            //             ->required(),
            //     ])
            //     ->action(function ($data) {
            //         $this->filter = $data['filter'];
            //         dd($this->filter);
            //         $this->getHeaderWidgets();
            //     })
            ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            InvoicingStats::make(['filter' => $this->filter]),
            InvoicingChart::make(['filter' => $this->filter]),
            LatestSales::class,
        ];
    }

}
