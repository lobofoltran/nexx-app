<?php

namespace App\Services;

use App\Actions\CreateNewTableMovimentationAction;
use App\Enums\CardPhysicalStatus;
use App\Models\Call;
use App\Models\CardPhysical;
use App\Models\Table;

class CallService
{
    public static function setDone(Call $call): Call
    {
        $call->done = true;
        $call->save();
    
        CreateNewTableMovimentationAction::handle($call->table, Table::class, $call->table->id, 'update', 'Chamado atendido');

        return $call;
    }
}