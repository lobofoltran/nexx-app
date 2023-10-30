<?php

namespace App\Actions;

use App\Enums\CardStatus;
use App\Models\Card;
use App\Models\Table;
use App\Services\TableService;

class CreateNewCardAction
{
    private static ?string $table_id = null;

    public static function handle(?Table $table = null, ?string $identity = null): Card
    {
        self::validate($table);

        $card = new Card;
        $card->atcm_table_id = self::$table_id;
        $card->identity = trim($identity);
        $card->status = CardStatus::Active->value;
        $card->save();

        CreateNewCardMovimentationAction::handle($card, Card::class, $card->id, 'create', 'Abertura da comanda');

        if ($table) {
            TableService::setInUse($table);
        }

        return $card;
    }

    private static function validate(?Table $table): void
    {
        self::clean();

        if ($table) {
            if (!$table->exists()) throw new \Exception(__('Mesa não existe!'), 1);

            self::$table_id = $table->id;
        }
    }

    private static function clean(): void
    {
        self::$table_id = null;
    }
}
