<?php

namespace Database\Factories;

use App\Models\Membership;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MembershipFactory extends Factory
{
    protected $model = Membership::class;

    public function definition(): array
    {
        $currentDate = Carbon::now();

        return [
            'start_at' => $currentDate,
            'end_at' => $currentDate->addMonth(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'promotion_id' => Promotion::factory(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => User::factory(),
        ];
    }
}
