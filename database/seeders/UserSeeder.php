<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enterprise_1 = \App\Models\Enterprise::factory()->create([
            'name'        => "Joe's Bar",
            'active'      => true,
            'free_to_pay' => true,
        ]);

        $enterprise_2 = \App\Models\Enterprise::factory()->create([
            'name'        => "Seu Zé Bar",
            'active'      => true,
            'free_to_pay' => true,
        ]);

        $user = \App\Models\User::factory()->create([
            'name'  => 'Gustavo Lobo',
            'email' => 'gustavoqe.75@gmail.com',
        ]);

        \App\Models\EnterpriseUser::factory()->create([
            'user_id' => $user->id,
            'enterprise_id' => $enterprise_1->id,
        ]);

        foreach (RolesEnum::cases() as $case) {
            $user->assignRole($case->value);
        }

        $user = \App\Models\User::factory()->create([
            'name'  => 'Admin Empresa 2',
            'email' => 'admin2@test.com',
        ]);

        \App\Models\EnterpriseUser::factory()->create([
            'user_id' => $user->id,
            'enterprise_id' => $enterprise_2->id,
        ]);

        foreach (RolesEnum::cases() as $case) {
            $user->assignRole($case->value);
        }

        $user = \App\Models\User::factory()->create([
            'name'  => 'Garçom 1',
            'email' => 'garcom@teste.com',
        ]);

        \App\Models\EnterpriseUser::factory()->create([
            'user_id' => $user->id,
            'enterprise_id' => $enterprise_1->id,
        ]);

        $user->assignRole(RolesEnum::WAITER->value);

        $user = \App\Models\User::factory()->create([
            'name'  => 'Cozinheiro 1',
            'email' => 'cozinha@teste.com',
        ]);

        \App\Models\EnterpriseUser::factory()->create([
            'user_id' => $user->id,
            'enterprise_id' => $enterprise_1->id,
        ]);

        $user->assignRole(RolesEnum::KITCHEN->value);

        $user = \App\Models\User::factory()->create([
            'name'  => 'Bar 1',
            'email' => 'bar@teste.com',
        ]);

        \App\Models\EnterpriseUser::factory()->create([
            'user_id' => $user->id,
            'enterprise_id' => $enterprise_1->id,
        ]);

        $user->assignRole(RolesEnum::BAR->value);

        $user = \App\Models\User::factory()->create([
            'name'  => 'Caixa 1',
            'email' => 'caixa@teste.com',
        ]);

        \App\Models\EnterpriseUser::factory()->create([
            'user_id' => $user->id,
            'enterprise_id' => $enterprise_1->id,
        ]);

        $user->assignRole(RolesEnum::CASHIER->value);

        $user = \App\Models\User::factory()->create([
            'name'  => 'Atrações 1',
            'email' => 'atracao@teste.com',
        ]);

        \App\Models\EnterpriseUser::factory()->create([
            'user_id' => $user->id,
            'enterprise_id' => $enterprise_1->id,
        ]);

        $user->assignRole(RolesEnum::ATTRACTION->value);

        $user = \App\Models\User::factory()->create([
            'name'  => 'Administrador 1',
            'email' => 'admin@teste.com',
        ]);

        \App\Models\EnterpriseUser::factory()->create([
            'user_id' => $user->id,
            'enterprise_id' => $enterprise_1->id,
        ]);

        $user->assignRole(RolesEnum::ADMIN->value);

        // \App\Models\User::factory(10)->create();
    }
}
