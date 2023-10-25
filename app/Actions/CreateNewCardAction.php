<?php

namespace App\Actions;
use App\Models\Card;

class CreateNewCardAction
{
    public function handle(array $cardData): Card
    {
        return Card::create([
        ]);
    }
}
