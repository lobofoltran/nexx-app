<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum OrderItemsStatus: string
{
    use OptionsEnum;

    case Assessing = 'assessing';
    case Rejected = 'rejected';
    case Preparing = 'preparing';
    case Concluded = 'concluded';
    case Delivered = 'delivered';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match($this) {
            static::Assessing => 'Avaliando',
            static::Rejected  => 'Rejeitado',
            static::Preparing => 'Preparando',
            static::Concluded => 'Concluído',
            static::Delivered => 'Entregue',
            static::Canceled  => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match($this) {
            static::Assessing => 'yellow',
            static::Rejected  => 'red',
            static::Preparing => 'blue',
            static::Concluded => 'blue',
            static::Delivered => 'green',
            static::Canceled  => 'red',
        };
    }
}