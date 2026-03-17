<?php

namespace Database\Factories;

use App\Models\Price;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends Factory<Price>
 */
class PriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => random_int(1, 15),
            'price' => random_int(10, 150),
            'price_date' => Carbon::now()->subDays(rand(0, 7))->startOfDay(),
        ];
    }
}
