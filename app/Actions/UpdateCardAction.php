<?php

namespace App\Actions;
use App\Models\Card;

class UpdateCardAction
{
    public static function handle(Card $card, array $cardData): Card
    {
        return $card;
    }
}
