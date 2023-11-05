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

    public function color(): string
    {
        return match($this) {
            static::Available => 'border-green-500 bg-green-500 text-white',
            static::InUse     => 'border-blue-500 bg-blue-500 text-white',
            static::Disabled  => 'border-zinc-500 bg-zinc-500 text-white',
        };
    }

    public function icon(): string
    {
        return match($this) {
            static::Available => 'fas fa-circle-play',
            static::InUse     => 'fas fa-circle-check',
            static::Disabled  => 'fas fa-circle-pause',
        };
    }
}