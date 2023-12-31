<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) { 
            Table::factory()->create([
                'identity' => 'Mesa ' . str_pad($i, 3, '0', STR_PAD_LEFT),
            ]);
        }
    }
}
