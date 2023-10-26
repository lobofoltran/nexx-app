<?php

namespace App\Actions;
use App\Models\WaitingList;

class UpdateWaitingListAction
{
    public static function handle(WaitingList $waitingList, array $waitingListData): WaitingList
    {
        return $waitingList;
    }
}
