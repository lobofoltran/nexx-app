<?php

namespace App\Services;
use App\Actions\CreateNewTableMovimentationAction;
use App\Enums\CardStatus;
use App\Enums\TableStatus;
use App\Models\Table;

class TableService
{
    public static function removeGroupment(Table $table, Table $toTable): array
    {
        if (sizeof($table->groupments) <= 0) {
            $table->status = TableStatus::InUse->value;
            $table->save();    
        }

        if (sizeof($toTable->groupments) <= 0) {
            $toTable->status = TableStatus::InUse->value;
            $toTable->save();    
        }

        return [$table, $toTable];
    }

    public static function setAvailable(Table $table): Table
    {
        $table->refresh();

        $table->cards_quantity = self::getQuantityCards($table); 

        if (!self::hasCostumerInTable($table)) {
            $table->cards_quantity = 0;
            $table->status = TableStatus::Available->value;

            CreateNewTableMovimentationAction::handle($table, Table::class, $table->id, 'update', 'Status da mesa alterado para "Disponível"');
        }

        CreateNewTableMovimentationAction::handle($table, Table::class, $table->id, 'update', 'Quantidade de comandas alterada para "' . $table->cards_quantity . '"');
        
        $table->save();

        return $table;
    }

    public static function hasCostumerInTable(Table $table): bool
    {
        $has = false;

        foreach ($table->cards->whereIn('status', [CardStatus::Active->value, CardStatus::Grouped->value]) as $card) {
            if ($table->id == $card->table->id) {
                $has = true;
            }
        }

        return $has;
    }

    public static function getQuantityCards(Table $table): int
    {
        $count = 0;

        $table->refresh();
        
        foreach ($table->cards->whereIn('status', [CardStatus::Active->value, CardStatus::Grouped->value]) as $card) {
            if ($table->id == $card->table->id) {
                $count += 1;
            }
        }

        return $count;
    }

    public static function setGrouped(Table $table, Table $toTable): array
    {
        $table->status = TableStatus::Grouped->value;
        $table->save();

        CreateNewTableMovimentationAction::handle($table, Table::class, $table->id, 'update', 'Status da mesa alterado para "Agrupado"');

        $toTable->status = TableStatus::Grouped->value;
        $toTable->save();

        CreateNewTableMovimentationAction::handle($toTable, Table::class, $toTable->id, 'update', 'Status da mesa alterado para "Agrupado"');

        return [$table, $toTable];
    }

    public static function setInUse(Table $table): Table
    {
        $table->cards_quantity = self::getQuantityCards($table); 
        $table->status = TableStatus::InUse->value;
        $table->save();

        CreateNewTableMovimentationAction::handle($table, Table::class, $table->id, 'update', 'Status da mesa alterado para "Em Uso" e quantidade de comandas: ' . $table->cards_quantity);

        return $table;
    }

    public static function setWaitingCleaning(Table $table): Table
    {
        if (self::verifyAllCardsTableClosed($table)) {
            $table->cards_quantity = 0;
            $table->status = TableStatus::WaitingCleaning->value;
            $table->save();

            CreateNewTableMovimentationAction::handle($table, Table::class, $table->id, 'update', 'Status da mesa alterado para "Aguardando Limpeza"');
        }

        return $table;
    }

    public static function verifyAllCardsTableClosed(Table $table): bool
    {
        $allClosed = true;

        foreach ($table->cards as $card) {
            if ($card->status !== CardStatus::Closed->value) {
                $allClosed = false;
            }
        }

        return $allClosed;
    }

    public static function setDisabled(Table $table): Table
    {
        $table->cards_quantity = 0;
        $table->status = TableStatus::Disabled->value;
        $table->save();

        CreateNewTableMovimentationAction::handle($table, Table::class, $table->id, 'update', 'Status da mesa alterado para "Desabilitado"');

        return $table;
    }

    public static function getConsummation(Table $table, bool $groupment = false): string
    {
        $consummation = 0;

        foreach ($table->cards->whereIn('status', CardStatus::Active->value, CardStatus::Grouped->value) as $card) {
            $consummation += $card->getConsummation($groupment);
        }

        return $consummation;
    }

    public static function getTime(Table $table): string
    {
        if ($table->cards->first()) {
            return CardService::getTime($table->cards->first());
        }

        return '00:00:00';
    }
}