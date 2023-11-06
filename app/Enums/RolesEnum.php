<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum RolesEnum: string
{
    use OptionsEnum;

    case WAITER = 'Garçom';
    case ATTRACTION = 'Atração';
    case BAR = 'Bar';
    case KITCHEN = 'Cozinha';
    case CASHIER = 'Caixa';
    case ADMIN = 'Administrador';

    public function label(): string
    {
        return match ($this) {
            static::WAITER => 'Garçom',
            static::ATTRACTION => 'Atração',
            static::BAR => 'Bar',
            static::KITCHEN => 'Cozinha',
            static::CASHIER => 'Caixa',
            static::ADMIN => 'Administrador',
        };
    }
}
