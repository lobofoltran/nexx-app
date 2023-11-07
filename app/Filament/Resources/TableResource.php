<?php

namespace App\Filament\Resources;

use App\Enums\TableStatus;
use App\Filament\Resources\TableResource\Pages;
use App\Filament\Resources\TableResource\RelationManagers;
use App\Models\Product;
use App\Models\Table as ModelTable;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TableResource extends Resource
{
    protected static ?string $model = ModelTable::class;
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Mesas';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $modelLabel = 'Mesa';
    protected static ?string $pluralModelLabel = 'Mesas';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informações da Mesa')
                    ->schema([
                        Forms\Components\TextInput::make('identity')
                            ->label('Identificação')
                            ->maxLength(50),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('identity')
                    ->label('Identificação')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->alignCenter()
                    ->badge()
                    ->color(function (Model $model): string {
                        return TableStatus::from($model->status)->badge();
                    })
                    ->state(function (Model $model): string {
                        return TableStatus::from($model->status)->label();
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dt. Criado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Dt. Atualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Dt. Deletado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()
            ], \Filament\Tables\Actions\HeaderActionsPosition::Bottom)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make()->exports([
                        \pxlrbt\FilamentExcel\Exports\ExcelExport::make()
                    ]),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTables::route('/'),
            'create' => Pages\CreateTable::route('/create'),
            'view' => Pages\ViewTable::route('/{record}'),
            'edit' => Pages\EditTable::route('/{record}/edit'),
        ];
    }    
}
