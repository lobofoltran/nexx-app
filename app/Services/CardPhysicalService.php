<?php

namespace App\Services;
use App\Enums\CardPhysicalStatus;
use App\Models\CardPhysical;

class CardPhysicalService
{
    public static function setAvailable(CardPhysical $cardPhysical): CardPhysical
    {
        $cardPhysical->status = CardPhysicalStatus::Available->value;
        $cardPhysical->save();
    
        return $cardPhysical;
    }

    public static function setInUse(CardPhysical $cardPhysical): CardPhysical
    {
        $cardPhysical->status = CardPhysicalStatus::InUse->value;
        $cardPhysical->save();

        return $cardPhysical;
    }
}