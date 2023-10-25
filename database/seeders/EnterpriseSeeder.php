<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnterpriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Enterprise::factory()->create([
            'name' => 'Bar Teste',
            'active' => true,
            'free_to_pay' => true,
        ]);

        \App\Models\Enterprise::factory(5)->create();
    }
}
