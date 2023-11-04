<?php

namespace App\Actions;

use App\Enums\CardPhysicalStatus;
use App\Models\CardPhysical;

class CreateNewCardPhysicalAction
{
    public static function handle(): CardPhysical
    {
        $cardPhysical = new CardPhysical;
        $cardPhysical->status = CardPhysicalStatus::Available->value;
        $cardPhysical->save();

        CreateNewAuditLogAction::handle(CardPhysical::class, $cardPhysical->id, 'create', 'Criada comanda física');

        return $cardPhysical;
    }
}
