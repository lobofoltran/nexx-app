<?php

namespace App\Actions;
use App\Models\WaitingList;

class UpdateWaitingListAction
{
    public function handle(WaitingList $waitingList, array $waitingListData): WaitingList
    {
        return $waitingList;
    }
}
