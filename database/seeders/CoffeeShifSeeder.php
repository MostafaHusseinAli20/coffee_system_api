<?php

namespace Database\Seeders;

use App\Models\Shif;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoffeeShifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shif::factory()->count(20)->create();
    }
}
