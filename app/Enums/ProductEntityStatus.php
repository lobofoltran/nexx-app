<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum ProductEntityStatus: string
{
    use OptionsEnum;

    case Available = 'available';
    case InUse = 'in_use';
    case Disabled  = 'disabled';

    public function label(): string
    {
        return match($this) {
            static::Available => 'Disponível',
            static::InUse     => 'Em Uso',
            static::Disabled  => 'Desabilitado',
        };
    }
}