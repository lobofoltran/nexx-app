<?php

namespace App\Services;
use App\Actions\CreateNewTableMovimentationAction;
use App\Enums\CardStatus;
use App\Enums\TableStatus;
use App\Models\Table;

class TableService
{
    public static function setAvailable(Table $table): Table
    {
        $table->cards_quantity = 0;
        $table->status = TableStatus::Available->value;
        $table->save();

        CreateNewTableMovimentationAction::handle($table, Table::class, $table->id, 'update', 'Status da mesa alterado para "Disponível"');

        return $table;
    }

    public static function setInUse(Table $table): Table
    {
        if ($table->status === TableStatus::InUse->value) {
            $table->cards_quantity += 1; 
        } else {
            $table->cards_quantity = 1;
        }

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
}