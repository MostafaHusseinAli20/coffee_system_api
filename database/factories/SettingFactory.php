<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coffee_id' => null, // Assuming you have a coffee with ID 1 in your database
            'active_theme' => $this->faker->randomElement(['light', 'dark']),
            'active_lang' => $this->faker->randomElement(['en', 'es', 'fr']),
            'active_currency' => $this->faker->randomElement(['USD', 'EUR', 'GBP']),
            'active_timezone' => $this->faker->timezone(),
            'active_direction' => $this->faker->randomElement(['ltr', 'rtl']),
        ];
    }
}
