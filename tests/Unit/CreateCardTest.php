<?php

namespace Tests\Unit;

use App\Actions\CreateNewCardAction;
use Tests\TestCase;

class CreateCardTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_card_can_created(): void
    {
        CreateNewCardAction::handle();

        $this->assertTrue(true);
    }
}
