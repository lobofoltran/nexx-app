<?php

namespace Database\Seeders;

use App\Models\CardPhysical;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardPhysicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) { 
            CardPhysical::factory()->create([
                'code' => str_pad($i, 3, '0', STR_PAD_LEFT),
            ]);
        }
    }
}
