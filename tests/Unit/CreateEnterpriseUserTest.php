<?php

namespace Tests\Unit;

use App\Actions\CreateNewEnterpriseAction;
use App\Actions\CreateNewEnterpriseUserAction;
use App\Actions\Fortify\CreateNewUser;
use Tests\TestCase;

class CreateEnterpriseUserTest extends TestCase
{
    public function test_enterprise_user_can_created(): void
    {
        $action = new CreateNewUser;

        $user = $action->create([
           'name' => fake()->name(),
           'email' => fake()->email(),
           'password' => '12345678',
           'password_confirmation' => '12345678',
           'terms' => true,
        ]);

        $enterprise = CreateNewEnterpriseAction::handle('Teste');
        
        $enterpriseUser = CreateNewEnterpriseUserAction::handle($user, $enterprise);

        $this->assertTrue($user->exists());
        $this->assertTrue($enterprise->exists());
        $this->assertTrue($enterpriseUser->exists());
    }
}
