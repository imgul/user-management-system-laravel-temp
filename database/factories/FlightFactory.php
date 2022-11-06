<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cust_name' => $this->faker->name(),
            'cust_email' => $this->faker->unique()->safeEmail(),
            'cust_phone' => $this->faker->phoneNumber(),
            'cust_address' => $this->faker->address(),
            'cust_country' => $this->faker->country(),
        ];
    }
}