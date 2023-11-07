<?php

namespace App\Filament\Widgets;

use App\Enums\OrderItemsStatus;
use App\Models\OrderItem;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestSales extends BaseWidget
{
    protected static ?string $heading = 'Últimas vendas';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                OrderItem::where('status', OrderItemsStatus::Delivered->value)
            )    
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dt. Criado')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produto')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost')
                    ->label('Custo')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('created_at')
                ->form([
                    DatePicker::make('created_from')
                        ->label('De data'),
                    DatePicker::make('created_until')
                        ->label('Até data'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make()->exports([
                        \pxlrbt\FilamentExcel\Exports\ExcelExport::make()
                    ]),
                ]),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()
            ]);
    }
}
