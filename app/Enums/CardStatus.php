<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum CardStatus: string
{
    use OptionsEnum;

    case Active = 'active';
    case Closed = 'closed';

    public function label(): string
    {
        return match($this) {
            static::Active => 'Ativo',
            static::Closed => 'Fechado',
        };
    }
}