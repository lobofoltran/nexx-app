<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum OrderItemsStatus: string
{
    use OptionsEnum;

    case Assessing = 'assessing';
    case Preparing = 'preparing';
    case Concluded = 'concluded';
    case Delivered = 'delivered';
    case Rejected = 'rejected';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match($this) {
            static::Assessing => 'Avaliando',
            static::Preparing => 'Preparando',
            static::Concluded => 'Concluído',
            static::Delivered => 'Entregue',
            static::Rejected  => 'Rejeitado',
            static::Canceled  => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match($this) {
            static::Assessing => 'text-white border-yellow-600 bg-yellow-500',
            static::Preparing => 'text-white border-sky-600 bg-sky-500',
            static::Concluded => 'text-white border-blue-600 bg-blue-500',
            static::Delivered => 'text-white border-green-600 bg-green-500',
            static::Rejected  => 'text-white border-red-600 bg-red-500',
            static::Canceled  => 'text-white border-red-600 bg-red-500'
        };
    }

    public function icon(): string
    {
        return match($this) {
            static::Assessing => 'fas fa-circle-exclamation',
            static::Preparing => 'fas fa-hammer',
            static::Concluded => 'fas fa-check-circle',
            static::Delivered => 'fas fa-truck',
            static::Rejected  => 'fas fa-times-circle',
            static::Canceled  => 'fas fa-times-circle'
        };
    }
}