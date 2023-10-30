<?php

namespace Tests\Unit;

use App\Actions\CreateNewWaitingListAction;
use Tests\TestCase;

class CreateWaitingListTest extends TestCase
{
    public function test_waiting_list_can_created(): void
    {
        $waitingList = CreateNewWaitingListAction::handle('Família 1');

        $this->assertTrue($waitingList->exists());
    }
}
