<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLogResource\Pages;
use App\Models\AuditLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationLabel = 'Logs de Auditoria';
    protected static ?string $navigationGroup = 'Relatórios';
    protected static ?string $modelLabel = 'Log de Auditoria';
    protected static ?string $pluralModelLabel = 'Logs de Auditoria';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('action')
                    ->badge()
                    ->label('Ação')
                    ->searchable(),
                Tables\Columns\TextColumn::make('details')
                    ->label('Detalhes'),
                Tables\Columns\TextColumn::make('model_type')
                    ->label('Model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model_id')
                    ->label('ID Model')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dt. Criado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListAuditLogs::route('/'),
        ];
    }    
}
