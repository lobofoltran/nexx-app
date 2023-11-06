<?php

namespace App\Actions;

use App\Enums\CardPhysicalStatus;
use App\Models\CardPhysical;

class CreateNewCardPhysicalAction
{
    public static function handle(?string $code = null): CardPhysical
    {
        $cardPhysical = new CardPhysical;
        $cardPhysical->code = $code;
        $cardPhysical->status = CardPhysicalStatus::Available->value;
        $cardPhysical->save();

        CreateNewAuditLogAction::handle(CardPhysical::class, $cardPhysical->id, 'create', 'Criada comanda física');

        return $cardPhysical;
    }
}
