<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogsQrCodeResource\Pages;
use App\Filament\Resources\LogsQrCodeResource\RelationManagers;
use App\Models\LogsQrCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LogsQrCodeResource extends Resource
{
    protected static ?string $model = LogsQrCode::class;
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'Logs Qr Code';
    protected static ?string $navigationGroup = 'Relatórios';
    protected static ?string $modelLabel = 'Log Qr Code';
    protected static ?string $pluralModelLabel = 'Logs Qr Code';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model')
                    ->label('Model')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_model')
                    ->label('ID Model')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('Endereço de IP')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dt. Criado')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListLogsQrCodes::route('/'),
            'create' => Pages\CreateLogsQrCode::route('/create'),
            'edit' => Pages\EditLogsQrCode::route('/{record}/edit'),
        ];
    }    
}
