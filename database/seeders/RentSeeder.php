<?php

namespace Database\Seeders;

use App\Models\Rent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class RentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; ++$i) {
            Rent::create([
                'name' => fake()->sentence(2),
                'price' => rand(500000, 1500000),
                'rent_date' => fake()->dateTime('now'),
                'availability' => (bool)rand(0, 1),
            ]);
        }
    }
}
