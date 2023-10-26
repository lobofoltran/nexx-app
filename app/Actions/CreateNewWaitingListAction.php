<?php

namespace App\Actions;
use App\Models\WaitingList;

class CreateNewWaitingListAction
{
    public static function handle(array $waitingListData): WaitingList
    {
        return WaitingList::create([
        ]);
    }
}
