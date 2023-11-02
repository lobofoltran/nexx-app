<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum TableStatus: string
{
    use OptionsEnum;

    case Available = 'available';
    case InUse = 'in_use';
    case Grouped = 'grouped';
    case Reserved = 'reserved';
    case Maintenance = 'maintenance';
    case WaitingCleaning = 'waiting';
    case Disabled = 'disabled';


    public function label(): string
    {
        return match($this) {
            static::Available       => 'Disponível',
            static::InUse           => 'Em Uso',
            static::Reserved        => 'Reservada',
            static::Grouped         => 'Agrupada',
            static::Maintenance     => 'Manutenção',
            static::WaitingCleaning => 'Esperando Limpeza',
            static::Disabled        => 'Desabilitado',
        };
    }

    public function color(): string
    {
        return match($this) {
            static::Available       => 'yellow',
            static::InUse           => 'green',
            static::Reserved        => 'orange',
            static::Grouped         => 'sky',
            static::Maintenance     => 'grey',
            static::WaitingCleaning => 'Esperando Limpeza',
            static::Disabled        => 'red',
        };
    }

}