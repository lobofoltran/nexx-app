<?php

namespace Tests\Unit;

use App\Actions\CreateNewEnterpriseAction;
use Tests\TestCase;

class CreateEnterpriseTest extends TestCase
{
    public function test_enterprise_can_created(): void
    {
        $enterprise = CreateNewEnterpriseAction::handle('Teste');

        $this->assertTrue($enterprise->exists());
    }
}
