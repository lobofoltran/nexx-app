<?php

namespace App\Actions;

use App\Models\WaitingList;

class CreateNewWaitingListAction
{
    public static function handle(string $name): WaitingList
    {
        $waitingList = new WaitingList;
        $waitingList->name = trim($name);
        $waitingList->done = false;
        $waitingList->save();

        CreateNewAuditLogAction::handle(WaitingList::class, $waitingList->id, 'create', 'Criada a Lista de Espera');

        return $waitingList;
    }
}
