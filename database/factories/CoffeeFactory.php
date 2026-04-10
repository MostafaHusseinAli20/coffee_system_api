<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coffee>
 */
class CoffeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'join_date' => $this->faker->date(),
            'address' => $this->faker->address(),
            'type' => $this->faker->randomElement(['coffee', 'resturant']),
            'website' => $this->faker->url(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
