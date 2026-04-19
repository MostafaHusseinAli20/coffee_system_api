<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ShifFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coffee_id' => $this->faker->numberBetween(10, 29),
            'user_id' => 1,
            'total_amount' => $this->faker->randomFloat(2, 100, 1000),
            'status' => $this->faker->randomElement(['fixed', 'open']),
            'from' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'to' => $this->faker->dateTimeBetween('now', '+1 month'),
            'opened_by' => 1,
            'closed_by' => 1,
            'notes' => $this->faker->sentence(),
        ];
    }
}
