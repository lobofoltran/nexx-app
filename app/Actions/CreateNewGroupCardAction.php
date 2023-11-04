<?php

namespace App\Actions;

use App\Models\Card;
use App\Models\GroupCard;
use App\Services\CardService;

class CreateNewGroupCardAction
{
    private static string $card_id;
    private static string $card_to_id;

    public static function handle(?Card $card, ?Card $toCard): GroupCard
    {
        self::validate($card, $toCard);

        $groupCard = new GroupCard;
        $groupCard->atcm_card_id = self::$card_id;
        $groupCard->atcm_card_id_to = self::$card_to_id;
        $groupCard->save();

        $groupCard = new GroupCard;
        $groupCard->atcm_card_id = self::$card_to_id;
        $groupCard->atcm_card_id_to = self::$card_id;
        $groupCard->save();

        CreateNewCardMovimentationAction::handle($card, Card::class, $card->id, 'update', 'Vínculo criado com a comanda "' . $toCard->id . '"');

        CardService::setGrouped($card, $toCard);

        return $groupCard;
    }

    private static function validate(?Card $card, ?Card $toCard): void
    {
        if ($card) {
            if (!$card->exists()) throw new \Exception(__('Comanda não existe!'), 1);
        } else {
            throw new \Exception(__('Comanda não existe!'), 2);
        }

        if ($toCard) {
            if (!$toCard->exists()) throw new \Exception(__('Comanda não existe!'), 3);
        } else {
            throw new \Exception(__('Comanda não existe!'), 4);
        }

        if ($card->id == $toCard->id) {
            throw new \Exception(__('Comanda não pode ser a mesma!'), 5);
        }

        self::$card_id = $card->id;
        self::$card_to_id = $toCard->id;
    }
}
