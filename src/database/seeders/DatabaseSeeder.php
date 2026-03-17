<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use App\Models\Price;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        Manufacturer::factory(5)->create();
        Product::factory(15)->create();
        Price::factory(30)->create();

        $this->call([
            ProcessStatusesSeeder::class,
        ]);
    }
}
