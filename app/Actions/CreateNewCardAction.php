<?php

namespace App\Actions;

use App\Enums\CardStatus;
use App\Models\Card;
use App\Models\CardPhysical;
use App\Models\Table;
use App\Services\CardPhysicalService;
use App\Services\TableService;

class CreateNewCardAction
{
    private static ?string $table_id = null;
    private static ?string $card_physical_id = null;

    public static function handle(?Table $table = null, ?string $identity = null, ?CardPhysical $cardPhysical = null): Card
    {
        self::validate($table, $cardPhysical);

        $card = new Card;
        $card->atcm_table_id = self::$table_id;
        $card->atcm_card_physical_id = self::$card_physical_id;
        $card->identity = trim($identity);
        $card->status = CardStatus::Active->value;
        $card->save();

        CreateNewCardMovimentationAction::handle($card, Card::class, $card->id, 'create', 'Abertura da comanda');

        if ($table) {
            TableService::setInUse($table);
        }

        if ($cardPhysical) {
            CardPhysicalService::setInUse($cardPhysical);
        }

        return $card;
    }

    private static function validate(?Table $table, ?CardPhysical $cardPhysical): void
    {
        self::clean();

        if ($table) {
            if (!$table->exists()) throw new \Exception(__('Mesa não existe!'), 1);

            self::$table_id = $table->id;
        }

        if ($cardPhysical) {
            if (!$cardPhysical->exists()) throw new \Exception(__('Comanda física não existe!'), 2);

            self::$card_physical_id = $cardPhysical->id;
        }
    }

    private static function clean(): void
    {
        self::$table_id = null;
        self::$card_physical_id = null;
    }
}
