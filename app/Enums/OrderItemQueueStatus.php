<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum OrderItemQueueStatus: string
{
    use OptionsEnum;

    case InQueue = 'in_queue';
    case Playing = 'playing';
    case Done = 'done';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match($this) {
            static::InQueue   => 'Na Fila',
            static::Playing   => 'Jogando',
            static::Done      => 'Finalizado',
            static::Canceled  => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match($this) {
            static::InQueue   => 'border-green-500 bg-green-500 text-white',
            static::Playing   => 'border-blue-500 bg-blue-500 text-white',
            static::Done      => 'border-zinc-500 bg-zinc-500 text-white',
            static::Canceled  => 'border-red-500 bg-red-500 text-white',
        };
    }

    public function icon(): string
    {
        return match($this) {
            static::InQueue   => 'fas fa-circle-pause',
            static::Playing   => 'fas fa-circle-play',
            static::Done      => 'fas fa-check-circle',
            static::Canceled  => 'fas fa-circle-xmark',
        };
    }
}