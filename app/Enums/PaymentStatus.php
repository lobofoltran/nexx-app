<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum PaymentStatus: string
{
    use OptionsEnum;

    case Open = 'open';
    case Concluded = 'concluded';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match($this) {
            static::Open      => 'Aberto',
            static::Concluded => 'Concluído',
            static::Canceled  => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match($this) {
            static::Open      => 'blue',
            static::Concluded => 'green',
            static::Canceled  => 'red',
        };
    }

}