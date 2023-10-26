<?php

namespace App\Actions;
use App\Models\Card;
use Illuminate\Support\Facades\Gate;

class CreateNewCardAction
{
    public static function handle(array $cardData = []): Card
    {
        $card = new Card;
        
        if (isset($cardData['atcm_table_id']) && !empty($cardData['atcm_table_id'])) {
            $card->atcm_table_id = $cardData['atcm_table_id'];
        }

        if (isset($cardData['identity']) && !empty($cardData['identity'])) {
            $card->identity = $cardData['identity'];
        }

        $card->save();

        return $card;
    }
}
