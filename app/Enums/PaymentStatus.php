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
            static::Open      => 'text-white bg-blue-500 border-blue-600',
            static::Concluded => 'text-white bg-green-500 border-green-600',
            static::Canceled  => 'text-white bg-red-500 border-red-600',
        };
    }
}