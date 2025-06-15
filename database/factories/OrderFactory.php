<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status_id' => $this->faker->randomElement([1, 2, 3]),
            'user_id' => $this->faker->randomElement([1, 2]),
            'address' => $this->faker->address,
            'phoneNumber' => $this->faker->phoneNumber,
            'deliveryTime' => date('H:i:s', rand(1,5400)),
            'email' => $this->faker->unique()->safeEmail,
            'totalPrice' => $this->faker->randomFloat(null, 1000, 10000),
            'created_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
        ];
    }
}
