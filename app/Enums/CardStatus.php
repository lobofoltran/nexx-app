<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum CardStatus: string
{
    use OptionsEnum;

    case Active = 'active';
    case Grouped = 'grouped';
    case Closed = 'closed';

    public function label(): string
    {
        return match($this) {
            static::Active => 'Ativo',
            static::Grouped => 'Agrupado',
            static::Closed => 'Encerrado',
        };
    }

    public function color(): string
    {
        return match($this) {
            static::Active => 'text-white border-blue-600 bg-blue-500',
            static::Grouped => 'text-white border-sky-600 bg-sky-500',
            static::Closed => 'text-white border-red-600 bg-red-500',
        };
    }
}