<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomNumber(4),
            'last_received_at' => Carbon::now(),
            'last_sold_at' => Carbon::now(),
            'reorder_level' => $this->faker->randomNumber(4),
            'max_level' => $this->faker->randomNumber(4),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'product_id' => Product::factory(),
        ];
    }
}
