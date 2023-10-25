<?php

namespace App\Enums;

use App\Traits\OptionsEnum;

enum OrderStatus: string
{
    use OptionsEnum;

    case Preparing = ['preparing', 'Preparando'];
    case Concluded = ['concluded', 'Concluído'];
    case PartialCanceled = ['partial_canceled', 'Parcialmente Cancelado'];
    case Canceled  = ['canceled', 'Cancelado'];
}