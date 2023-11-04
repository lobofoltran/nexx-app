<?php

namespace App\Actions;

use App\Models\Card;
use App\Models\GroupCard;
use App\Services\CardService;

class DeleteGroupCardAction
{
    public static function handle(?GroupCard $groupCard): void
    {
        self::validate($groupCard);

        $atcm_card_id = $groupCard->atcm_card_id;
        $atcm_card_id_to = $groupCard->atcm_card_id_to;

        $first = GroupCard::where('atcm_card_id', $atcm_card_id)->where('atcm_card_id_to', $atcm_card_id_to)->first();
        $second = GroupCard::where('atcm_card_id_to', $atcm_card_id)->where('atcm_card_id', $atcm_card_id_to)->first();
        $first->delete();
        $second->delete();

        CreateNewCardMovimentationAction::handle(Card::find($atcm_card_id), Card::class, $atcm_card_id, 'update', 'Vínculo removido com a comanda "' . $atcm_card_id_to . '"');
        CreateNewCardMovimentationAction::handle(Card::find($atcm_card_id_to), Card::class, $atcm_card_id_to, 'update', 'Vínculo removido com a comanda "' . $atcm_card_id . '"');
    
        CardService::removeGroupment(Card::find($atcm_card_id), Card::find($atcm_card_id_to));
    }

    private static function validate(?GroupCard $groupCard): void
    {
        if ($groupCard) {
            if (!$groupCard->exists()) throw new \Exception(__('Vínculo não existe!'), 1);
        } else {
            throw new \Exception(__('Vínculo não existe!'), 2);
        }
    }
}
