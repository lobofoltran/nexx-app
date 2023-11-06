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
        $user = \App\Models\User::factory()->create([
            'name' => 'Gustavo Lobo',
            'email' => 'gustavoqe.75@gmail.com',
        ]);

        foreach (RolesEnum::cases() as $case) {
            $user->assignRole($case->value);
        }

        \App\Models\User::factory(10)->create();
    }
}
