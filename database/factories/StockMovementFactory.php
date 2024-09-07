<?php

namespace Database\Factories;

use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StockMovementFactory extends Factory
{
    protected $model = StockMovement::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['in', 'out']),
            'date' => Carbon::now(),
            'quantity' => $this->faker->randomNumber(3),
            'reason' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'stock_id' => Stock::factory(),
        ];
    }
}
