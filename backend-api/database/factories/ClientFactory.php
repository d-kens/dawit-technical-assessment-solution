<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'marital_status' => $this->faker->randomElement(['single', 'married']),
            'date_of_birth' => $this->faker->date(),
            'approval_status' => $this->faker->boolean(50), // 50% chance of being true
        ];
    }
}
