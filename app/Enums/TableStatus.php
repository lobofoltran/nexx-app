<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum TableStatus: string
{
    use OptionsEnum;

    case Available = 'available';
    case InUse = 'in_use';
    case Grouped = 'grouped';
    // case Reserved = 'reserved';
    case WaitingCleaning = 'waiting';
    case Maintenance = 'maintenance';
    case Disabled = 'disabled';


    public function label(): string
    {
        return match($this) {
            static::Available       => 'Disponível',
            static::InUse           => 'Em Uso',
            // static::Reserved        => 'Reservada',
            static::Grouped         => 'Agrupada',
            static::Maintenance     => 'Manutenção',
            static::WaitingCleaning => 'Ag. Limpeza',
            static::Disabled        => 'Desabilitado',
        };
    }

    public function color(): string
    {
        return match($this) {
            static::Available       => 'border-green-500 bg-green-500 text-white',
            static::InUse           => 'border-blue-500 bg-blue-500 text-white',
            // static::Reserved        => 'border-blue-500 bg-blue-500 text-white',
            static::Grouped         => 'border-sky-500 bg-sky-500 text-white',
            static::WaitingCleaning => 'border-zinc-500 bg-zinc-500 text-white',
            static::Maintenance     => 'border-red-500 bg-red-500 text-white',
            static::Disabled        => 'border-red-500 bg-red-500 text-white',
        };
    }

    public function icon(): string
    {
        return match($this) {
            static::Available       => 'fas fa-circle-pause',
            static::InUse           => 'fas fa-circle-check',
            // static::Reserved        => '',
            static::Grouped         => 'fas fa-link',
            static::WaitingCleaning => 'fas fa-broom',
            static::Maintenance     => 'fas fa-circle-exclamation',
            static::Disabled        => 'fas fa-times-circle',
        };
    }

}