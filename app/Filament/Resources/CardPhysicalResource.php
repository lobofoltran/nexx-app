<?php

namespace App\Filament\Resources;

use App\Enums\CardPhysicalStatus;
use App\Filament\Resources\CardPhysicalResource\Pages;
use App\Filament\Resources\CardPhysicalResource\RelationManagers;
use App\Models\CardPhysical;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CardPhysicalResource extends Resource
{
    protected static ?string $model = CardPhysical::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Comandas Físicas';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $modelLabel = 'Comanda Física';
    protected static ?string $pluralModelLabel = 'Comandas Físicas';
    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Mesa')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Código'),
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
                Tables\Columns\TextColumn::make('code')
                    ->label('Código')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable()
                    ->alignCenter()
                    ->color(function (Model $record): string {
                        return CardPhysicalStatus::from($record->status)->badge();
                    })
                    ->getStateUsing(function (Model $record): string {
                        return CardPhysicalStatus::from($record->status)->label();
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //     Tables\Actions\DeleteBulkAction::make(),
                    \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make()->exports([
                        \pxlrbt\FilamentExcel\Exports\ExcelExport::make()
                    ]),
                ]),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()
            ], \Filament\Tables\Actions\HeaderActionsPosition::Bottom);
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
            'index' => Pages\ListCardPhysicals::route('/'),
            'create' => Pages\CreateCardPhysical::route('/create'),
            'edit' => Pages\EditCardPhysical::route('/{record}/edit'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
