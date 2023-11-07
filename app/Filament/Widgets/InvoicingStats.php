<?php

namespace App\Filament\Widgets;

use App\Enums\OrderItemsStatus;
use App\Models\OrderItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class InvoicingStats extends BaseWidget
{
    protected function getStats(): array
    {
        $data = $this->getData();

        return [
            Stat::make('Total de Vendas', $data['total']['total'])
                ->description($data['total']['description'])
                ->descriptionIcon('heroicon-m-arrow-' . $data['total']['icon'])
                ->chart($data['total']['chart'])
                ->color($data['total']['color']),
            Stat::make('Faturamento', $data['faturamento']['total'])
                ->description($data['faturamento']['description'])
                ->descriptionIcon('heroicon-m-arrow-' . $data['faturamento']['icon'])
                ->chart($data['faturamento']['chart'])
                ->color($data['faturamento']['color']),
            Stat::make('Vendas', $data['vendas']['total'])
                ->description($data['vendas']['description'])
                ->descriptionIcon('heroicon-m-arrow-' . $data['vendas']['icon'])
                ->chart($data['vendas']['chart'])
                ->color($data['vendas']['color']),
            Stat::make('Custos (produto)', $data['custos']['total'])
                ->description($data['custos']['description'])
                ->descriptionIcon('heroicon-m-arrow-' . $data['custos']['icon'])
                ->chart($data['custos']['chart'])
                ->color($data['custos']['color']),
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

    public function getGetDataFaturamento(Trend $trend): array
    {
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

        $valueLast = $trend
            ->between(
                start: now()->subMonth()->startOfMonth(),
                end: now()->subMonth(),
            )
            ->perDay()
            ->sum('value');

        $costLast = $trend
            ->between(
                start: now()->subMonth()->startOfMonth(),
                end: now()->subMonth(),
            )
            ->perDay()
            ->sum('cost');

        $totalValueCurrent = $this->getArrTrendValue($valueCurrent);
        $totalCostCurrent = $this->getArrTrendValue($costCurrent);
        $totalValueLast = $this->getArrTrendValue($valueLast);
        $totalCostLast = $this->getArrTrendValue($costLast);

        $totalVendasLastMonth = $totalValueLast - $totalCostLast;
        $totalVendasCurrentMonth = $totalValueCurrent - $totalCostCurrent;

        $chart = [];
        foreach ($valueCurrent as $key => $value) {
            $chart[$key] = $value->aggregate;
        }

        foreach ($costCurrent as $key => $value) {
            $chart[$key] = $chart[$key] - $value->aggregate;
        }


        $description = $totalVendasLastMonth > $totalVendasCurrentMonth ? ('R$ '. number_format(($totalVendasLastMonth - $totalVendasCurrentMonth), 2, ',', '.') . ' menor vs. mês anterior') : ('R$ '. number_format(($totalVendasCurrentMonth - $totalVendasLastMonth), 2, ',', '.') . ' maior vs. mês anterior');
        $chartVendas = $chart;
        $icon = $totalVendasLastMonth > $totalVendasCurrentMonth ? 'trending-down' : 'trending-up';
        $color = $totalVendasLastMonth > $totalVendasCurrentMonth ? 'danger' : 'success';

        return [
            'total' => 'R$ ' . number_format($totalVendasCurrentMonth, 2, ',', '.'), 
            'description' => $description, 
            'chart' => $chartVendas, 
            'icon' => $icon, 
            'color' => $color
        ];
    
    }

    public function getDataTrend(Trend $trend, string $column = '*'): array
    {
        if ($column == '*') {
            $currentMonthTotal = $trend
                ->between(
                    start: now()->startOfMonth(),
                    end: now(),
                )
                ->perDay()
                ->count();
        } else {
            $currentMonthTotal = $trend
                ->between(
                    start: now()->startOfMonth(),
                    end: now(),
                )
                ->perDay()
                ->sum($column);
        }

        if ($column === '*') {
            $lastMonthTotal = $trend
                ->between(
                    start: now()->subMonth()->startOfMonth(),
                    end: now()->subMonth(),
                )
                ->perDay()
                ->count();
        } else {
            $lastMonthTotal = $trend
                ->between(
                    start: now()->subMonth()->startOfMonth(),
                    end: now()->subMonth(),
                )
                ->perDay()
                ->sum($column);
        }

        $totalVendasLastMonth = 0;
        foreach ($lastMonthTotal as $value) {
            $totalVendasLastMonth += $value->aggregate;
        }

        $totalVendasCurrentMonth = 0;
        foreach ($currentMonthTotal as $value) {
            $totalVendasCurrentMonth += $value->aggregate;
        }

        $total = $totalVendasLastMonth > $totalVendasCurrentMonth ? $totalVendasLastMonth - $totalVendasCurrentMonth : $totalVendasCurrentMonth - $totalVendasLastMonth;
        $total = $column === '*' ? $total : 'R$ ' . number_format($total, 2, ',', '.');
        $description = $totalVendasLastMonth > $totalVendasCurrentMonth ? ($total . ' menor vs. mês anterior') : ($total . ' maior vs. mês anterior');
        $chartVendas = $currentMonthTotal->map(fn (TrendValue $value) => $value->aggregate);
        
        $icon = $totalVendasLastMonth > $totalVendasCurrentMonth ? 'trending-down' : 'trending-up';
        $color = $totalVendasLastMonth > $totalVendasCurrentMonth ? ($column == 'cost' ? 'success' : 'danger') : ($column == 'cost' ? 'danger' : 'success');

        return [
            'total' => ($column === '*' ? $totalVendasCurrentMonth : 'R$ ' . number_format($totalVendasCurrentMonth, 2, ',', '.')), 
            'description' => $description, 
            'chart' => $chartVendas->toArray(), 
            'icon' => $icon, 
            'color' => $color
        ];
    }

    public function getData(): array
    {
        $trend = Trend::query(OrderItem::where('status', OrderItemsStatus::Delivered->value));

        $array = [
            ['total', '*'],
            ['faturamento', ''],
            ['vendas', 'value'],
            ['custos', 'cost'],
        ];

        $return = [];
        foreach ($array as $arr) {
            if ($arr[0] == 'faturamento') {
                $return[$arr[0]] = $this->getGetDataFaturamento($trend);
            } else {
                $return[$arr[0]] = $this->getDataTrend($trend, $arr[1]);
            }
        }

        return $return;
    }
}
