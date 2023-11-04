<?php

namespace App\Actions;

use App\Enums\CardStatus;
use App\Models\Card;
use App\Models\CardPhysical;
use App\Models\Table;
use App\Services\CardPhysicalService;
use App\Services\TableService;

class UpdateCardAction
{    
    private static ?string $card_physical_id = null;
    private static ?string $table_id = null;
    private static string $textMovimentation;

    public static function handle(Card $card, ?string $identity = null, ?Table $table = null, ?CardPhysical $cardPhysical = null): Card
    {
        self::validate($card, $table, $identity, $cardPhysical);

        $oldTable = $card->table ? $card->table->id : '';
        $oldCardPhysical = $card->cardPhysical ? $card->cardPhysical->id : '';

        $card->atcm_card_physical_id = self::$card_physical_id;
        $card->atcm_table_id = self::$table_id;
        $card->identity = trim($identity);
        $card->save();

        CreateNewCardMovimentationAction::handle($card, Card::class, $card->id, 'update', self::$textMovimentation);

        if ($oldTable != self::$table_id) {
            if ($oldTable) {
                TableService::setAvailable(Table::find($oldTable));
            }

            if ($table instanceof Table) {
                TableService::setInUse($table);
            }
        }

        if ($oldCardPhysical != self::$card_physical_id) {
            if ($oldCardPhysical) {
                CardPhysicalService::setAvailable(CardPhysical::find($oldCardPhysical));
            }

            if ($cardPhysical instanceof CardPhysical) {
                CardPhysicalService::setInUse($cardPhysical);
            }
        }

        return $card;
    }

    private static function validate(Card $card, ?Table $table, ?string $identity, ?CardPhysical $cardPhysical): void
    {
        self::clean();

        self::$textMovimentation = 'Atualizada comanda:';

        if ($card->status === CardStatus::Closed->value) {
            throw new \Exception(__('Comanda não ativa! Impossível alterar.'), 1);
        }

        if ($table) {
            if (!$table->exists()) {
                throw new \Exception(__('Mesa não existe!'), 2);
            }

            self::$table_id = $table->id;
            self::$textMovimentation .= ' Mesa -> ' . $table->id . ';';
        }

        if ($cardPhysical) {
            if (!$cardPhysical->exists()) {
                throw new \Exception(__('Comanda física não existe!'), 2);
            }

            self::$card_physical_id = $cardPhysical->id;
            self::$textMovimentation .= ' Comanda Física -> ' . $cardPhysical->id . ';';
        }

        if ($identity && $card->identity != $identity) {
            self::$textMovimentation .= ' Identificação (' . $card->identity .') -> ' . $identity . ';';
        }
    }

    private static function clean(): void
    {
        self::$table_id = null;
        self::$card_physical_id = null;
    }
}
