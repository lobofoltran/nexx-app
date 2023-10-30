<?php

namespace App\Actions;

use App\Enums\CardStatus;
use App\Models\Card;
use App\Models\Table;
use App\Services\TableService;

class UpdateCardAction
{
    private static ?string $table_id = null;
    private static string $textMovimentation;

    public static function handle(Card $card, ?string $identity = null, ?Table $table = null): Card
    {
        self::validate($card, $table, $identity);

        $card->atcm_table_id = self::$table_id;
        $card->identity = trim($identity);
        $card->save();

        CreateNewCardMovimentationAction::handle($card, Card::class, $card->id, 'update', self::$textMovimentation);

        if ($table instanceof Table && $card->table !== $table) {
            TableService::setInUse($table);
        }

        return $card;
    }

    private static function validate(Card $card, ?Table $table = null, ?string $identity = null): void
    {
        self::clean();

        self::$textMovimentation = 'Atualizada comanda:';

        if ($card->status !== CardStatus::Active->value) {
            throw new \Exception(__('Comanda não ativa! Impossível alterar.'), 1);
        }

        if ($table && $card->table != $table) {
            if (!$table->exists()) {
                throw new \Exception(__('Mesa não existe!'), 2);
            }

            self::$table_id = $table->id;
            self::$textMovimentation .= ' Mesa -> ' . $table->id . ';';
        }

        if ($identity && $card->identity != $identity) {
            self::$textMovimentation .= ' Identificação (' . $card->identity .') -> ' . $identity . ';';
        }
    }

    private static function clean(): void
    {
        self::$table_id = null;
    }
}
