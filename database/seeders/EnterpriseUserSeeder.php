<?php

namespace Database\Seeders;

use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnterpriseUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\EnterpriseUser::factory()
            ->create([
                'user_id' => User::where('email', 'gustavoqe.75@gmail.com')->first()->id,
                'enterprise_id' => Enterprise::where('name', 'Bar Teste')->first()->id,
            ]);

        \App\Models\EnterpriseUser::factory()
            ->create([
                'user_id' => User::where('email', 'gustavoqe.75@gmail.com')->first()->id,
                'enterprise_id' => Enterprise::where('name', '!=', 'Bar Teste')->first()->id,
            ]);

        \App\Models\EnterpriseUser::factory(5)->create();
    }
}
