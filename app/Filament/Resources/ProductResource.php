<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\ProductCategory;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Produtos';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?string $modelLabel = 'Produto';
    protected static ?string $pluralModelLabel = 'Produtos';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informações do Produto')
                    ->schema([
                        Forms\Components\Select::make('atcm_products_categories_id')
                            ->relationship('productCategory', 'description')
                            ->label('Categoria do Produto')
                            ->required()
                            ->live(),
                        Forms\Components\TextInput::make('time')
                            ->label('Tempo da Atração')
                            ->required()
                            ->maxLength(255)
                            ->default('0')
                            ->hidden(function (Get $get): bool {
                                $productCategory = ProductCategory::find($get('atcm_products_categories_id'));

                                if (!$productCategory) {
                                    return true;
                                }

                                if ($productCategory->is_attraction) {
                                    return false;
                                }

                                return true;
                            })
                            ->helperText('Tempo em minutos de duração atração.'),
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\Textarea::make('description')
                            ->label('Descrição')
                            ->maxLength(100),
                        Forms\Components\FileUpload::make('image_url')
                            ->label('Imagem')
                            ->image(),
                        Forms\Components\TextInput::make('value')
                            ->label('Valor')
                            ->default('0')
                            ->required()
                            ->maxLength(10)
                            ->helperText('Utilize "." (ponto) para valores quebrados.'),
                        Forms\Components\TextInput::make('cost')
                            ->label('Custo')
                            ->default('0')
                            ->required()
                            ->maxLength(10)
                            ->helperText('Utilize "." (ponto) para valores quebrados.'),
                    ]),
                Section::make('Visibilidade')
                    ->schema([
                        Forms\Components\Toggle::make('show_to_bar')
                            ->label('Mostra para o Bar')
                            ->helperText('Assim que solicitado, irá mostrar para o bar')
                            ->hidden(function (Get $get): bool {
                                $productCategory = ProductCategory::find($get('atcm_products_categories_id'));

                                if (!$productCategory) {
                                    return true;
                                }

                                if ($productCategory->is_attraction) {
                                    return true;
                                }

                                return false;
                            }),
                        Forms\Components\Toggle::make('show_to_kitchen')
                            ->label('Mostra para a Cozinha')
                            ->helperText('Assim que solicitado, irá mostrar para a cozinha')
                            ->hidden(function (Get $get): bool {
                                $productCategory = ProductCategory::find($get('atcm_products_categories_id'));

                                if (!$productCategory) {
                                    return true;
                                }

                                if ($productCategory->is_attraction) {
                                    return true;
                                }

                                return false;
                            }),
                        Forms\Components\Toggle::make('show_to_cashier')
                            ->label('Mostra para o Caixa')
                            ->helperText('Assim que solicitado, irá mostrar para o caixa')
                            ->hidden(function (Get $get): bool {
                                $productCategory = ProductCategory::find($get('atcm_products_categories_id'));

                                if (!$productCategory) {
                                    return true;
                                }

                                if ($productCategory->is_attraction) {
                                    return true;
                                }

                                return false;
                            }),
                        Forms\Components\Toggle::make('active')
                            ->label('Ativo no Cardápio')
                            ->default(true),
                    ]),
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
                Tables\Columns\IconColumn::make('active')
                    ->label('Ativo')
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('productCategory.description')
                    ->label('Categoria')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image_url')
                    ->circular()
                    ->label('Imagem')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('show_to_bar')
                    ->label('Bar')
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('show_to_kitchen')
                    ->label('Cozinha')
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('show_to_cashier')
                    ->label('Caixa')
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('time')
                    ->label('Tempo')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
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
