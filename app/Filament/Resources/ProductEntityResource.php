<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductEntityResource\Pages;
use App\Filament\Resources\ProductEntityResource\RelationManagers;
use App\Models\Product;
use App\Models\ProductEntity;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductEntityResource extends Resource
{
    protected static ?string $model = ProductEntity::class;
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationLabel = 'Entidades de Atrações';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?string $modelLabel = 'Entidade de Atrações';
    protected static ?string $pluralModelLabel = 'Entidades de Atrações';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informações da Entidade da Atração')
                    ->schema([
                        Forms\Components\Select::make('atcm_product_id')
                            ->label('Atração (Produto)')
                            ->helperText('Selecione um produto da qual sua categoria é uma atração')
                            ->options(Product::query()->whereRelation('productCategory', 'is_attraction', true)->pluck('name', 'id'))
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
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
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produto')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProductEntities::route('/'),
            'create' => Pages\CreateProductEntity::route('/create'),
            'view' => Pages\ViewProductEntity::route('/{record}'),
            'edit' => Pages\EditProductEntity::route('/{record}/edit'),
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
