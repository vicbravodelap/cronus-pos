<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'discount' => $this->faker->randomNumber(3),
            'sku' => strtoupper($this->faker->unique()->bothify('???-#####')),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'image_path' => $this->faker->imageUrl(640, 480, 'products', true),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'category_id' => Category::factory(),
        ];
    }
}
