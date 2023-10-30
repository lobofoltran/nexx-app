<?php

namespace Tests\Unit;

use App\Actions\CreateNewCardAction;
use App\Actions\CreateNewTableAction;
use App\Actions\UpdateCardAction;
use App\Models\Table;
use Tests\TestCase;

class UpdateCardTest extends TestCase
{
    public function test_card_can_updated(): void
    {
        $card = CreateNewCardAction::handle();

        $this->assertTrue(!$card->table instanceof Table);

        $table = CreateNewTableAction::handle();

        $identity = 'Teste';
        
        UpdateCardAction::handle($card, $identity, $table);

        $card->refresh();

        $this->assertTrue($card->identity === $identity);
        $this->assertTrue($card->table instanceof Table);

        UpdateCardAction::handle($card);

        $card->refresh();

        $this->assertFalse($card->identity === $identity);
        $this->assertFalse($card->table instanceof Table);
    }
}
