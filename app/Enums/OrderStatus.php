<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum OrderStatus: string
{
    use OptionsEnum;

    case Preparing = 'preparing';
    case Concluded = 'concluded';
    case PartialCanceled = 'partial_canceled';
    case Canceled  = 'canceled';

    public function label(): string
    {
        return match($this) {
            static::Preparing       => 'Preparando',
            static::Concluded       => 'Concluído',
            static::PartialCanceled => 'Parcialmente Cancelado',
            static::Canceled        => 'Cancelado',
        };
    }
}