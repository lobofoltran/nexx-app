<?php

namespace Tests\Unit;

use App\Actions\CreateNewUserAction;
use App\Actions\Fortify\CreateNewUser;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    public function test_user_can_created(): void
    {
        $action = new CreateNewUser;

        $user = $action->create([
           'name' => fake()->name(),
           'email' => fake()->email(),
           'password' => '12345678',
           'password_confirmation' => '12345678',
           'terms' => true,
        ]);

        $this->assertTrue($user->exists());
    }
}
