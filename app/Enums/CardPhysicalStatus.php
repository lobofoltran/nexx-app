<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum CardPhysicalStatus: string
{
    use OptionsEnum;

    case Available = 'available';
    case InUse = 'in_use';
    case Disabled = 'disabled';

    public function label(): string
    {
        return match($this) {
            static::Available => 'Disponível',
            static::InUse     => 'Em Uso',
            static::Disabled  => 'Desabilitado',
        };
    }

    public function color(): string
    {
        return match($this) {
            static::Available => 'text-white border-green-600 bg-green-500',
            static::InUse     => 'text-white border-blue-600 bg-blue-500',
            static::Disabled  => 'text-white border-zinc-600 bg-zinc-500',
        };
    }

    public function icon(): string
    {
        return match($this) {
            static::Available => 'fas fa-circle-pause',
            static::InUse     => 'fas fa-check-circle',
            static::Disabled  => 'fas fa-times-circle',
        };
    }

}