<?php

namespace App\Filament\Widgets;

use App\Enums\OrderItemsStatus;
use App\Models\OrderItem;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class InvoicingChart extends ChartWidget
{
    protected static ?string $heading = 'Evolução de Vendas';
    public ?string $filter = 'month';
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];
    
    protected static ?string $maxHeight = '300px';


    public function getDescription(): ?string
    {
        return 'Evolução de vendas durante o período do mês selecionado.';
    }
    
    
    protected function getFilters(): ?array
    {
        return [
            'month' => 'Mês atual',
            'lastMonth' => 'Último mês',
        ];
    }
        
    protected function getData(): array
    {
        list($datasets, $labels) = $this->getDataChart();

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    public function getArrTrendValue($trend): string
    {
        $totalValorTrend = 0;

        foreach ($trend as $value) {
            $totalValorTrend += $value->aggregate;
        }

        return $totalValorTrend;
    }

    public function getDataChart(): array
    {
        $trend = Trend::query(OrderItem::where('status', OrderItemsStatus::Delivered->value));

        if ($this->filter == 'month') {
            $valueCurrent = $trend
                ->between(
                    start: now()->startOfMonth(),
                    end: now(),
                )
                ->perDay()
                ->sum('value');
    
            $costCurrent = $trend
                ->between(
                    start: now()->startOfMonth(),
                    end: now(),
                )
                ->perDay()
                ->sum('cost');
            $currentMonthTotal = $trend
                ->between(
                    start: now()->startOfMonth(),
                    end: now(),
                )
                ->perDay()
                ->count();
        } else if ($this->filter == 'lastMonth') {
                $valueCurrent = $trend
                ->between(
                        start: now()->subMonth()->startOfMonth(),
                        end: now()->subMonth()->endOfMonth(),
                    )
                ->perDay()
                ->sum('value');
    
            $costCurrent = $trend
                ->between(
                    start: now()->subMonth()->startOfMonth(),
                    end: now()->subMonth()->endOfMonth(),
            )
                ->perDay()
                ->sum('cost');
            $currentMonthTotal = $trend
                ->between(
                    start: now()->subMonth()->startOfMonth(),
                    end: now()->subMonth()->endOfMonth(),
            )
                ->perDay()
                ->count();

        }


        $chart = [];
        foreach ($valueCurrent as $key => $value) {
            $chart[$key] = $value->aggregate;
        }

        foreach ($costCurrent as $key => $value) {
            $chart[$key] = $chart[$key] - $value->aggregate;
        }

        $chartValue = [];
        foreach ($valueCurrent as $key => $value) {
            $chartValue[] = $value->aggregate;
        }

        $chartCost = [];
        foreach ($costCurrent as $key => $value) {
            $chartCost[] = $value->aggregate;
        }

        $chartTotal = [];
        foreach ($currentMonthTotal as $key => $value) {
            $chartTotal[] = $value->aggregate;
        }

        $datasets = [
            // [
            //     'label' => 'Total de Vendas',
            //     'data' => $chartTotal,
            //     'backgroundColor' => 'purple',
            //     'borderColor' => 'purple',    
            // ],
            [
                'label' => 'Faturamento (R$)',
                'data' => $chart,
                'backgroundColor' => 'blue',
                'borderColor' => 'blue',    
            ],
            [
                'label' => 'Vendas (R$)',
                'data' => $chartValue,
                'backgroundColor' => 'green',
                'borderColor' => 'green',    
            ],
            [
                'label' => 'Custos (R$)',
                'data' => $chartCost,
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]
        ];

        $labels = $valueCurrent->map(fn (TrendValue $value) => Carbon::createFromDate($value->date)->format('d/M'));

        return [$datasets, $labels];
    }


    protected function getType(): string
    {
        return 'line';
    }
}
