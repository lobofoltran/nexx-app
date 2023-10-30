<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum OrderItemQueueStatus: string
{
    use OptionsEnum;

    case InQueue = 'in_queue';
    case Done = 'done';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match($this) {
            static::InQueue   => 'Na Fila',
            static::Done      => 'Finalizado',
            static::Canceled  => 'Cancelado',
        };
    }
}