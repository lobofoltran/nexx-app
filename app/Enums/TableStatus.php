<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum TableStatus: string
{
    use OptionsEnum;

    case Available = 'available';
    case InUse = 'in_use';
    case WaitingCleaning = 'waiting';
    case Disabled = 'disabled';

    public function label(): string
    {
        return match($this) {
            static::Available       => 'Disponível',
            static::InUse           => 'Em Uso',
            static::WaitingCleaning => 'Esperando Limpeza',
            static::Disabled        => 'Desabilitado',
        };
    }
}