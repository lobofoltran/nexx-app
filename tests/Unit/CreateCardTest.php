<?php

namespace Tests\Unit;

use App\Actions\CreateNewCardAction;
use App\Actions\CreateNewTableAction;
use Tests\TestCase;

class CreateCardTest extends TestCase
{
    public function test_card_can_created(): void
    {
        $card = CreateNewCardAction::handle();

        $this->assertTrue($card->exists());
    }

    public function test_card_and_table_can_created(): void
    {
        $table = CreateNewTableAction::handle();
        $card = CreateNewCardAction::handle($table);

        $this->assertTrue($table->exists());
        $this->assertTrue($card->exists());
    }

    public function test_card_in_table_in_use_throws(): void
    {
        $table = CreateNewTableAction::handle();
        $this->assertTrue($table->exists());

        // Create first
        $card = CreateNewCardAction::handle($table);
        $this->assertTrue($card->exists());
        // Create second
        $card = CreateNewCardAction::handle($table);
        $this->assertTrue($card->exists());

        $this->assertTrue($table->cards_quantity === 2);
    }

    public function test_card_with_identity_can_created(): void
    {
        $identity = 'Teste';

        $card = CreateNewCardAction::handle(null, $identity);

        $this->assertTrue($card->exists());
        $this->assertTrue($card->identity === $identity);
    }
}
