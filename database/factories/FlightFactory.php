<?php

namespace Database\Factories;

// use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
// class FlightFactory extends Factory
// {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
//     public function definition()
//     {
//         return [
//             'cust_name' => faker()->name(),
//             'cust_email' => faker()->email(),
//             'cust_phone' => faker()->phoneNumber(),
//             'cust_address' => faker()->address(),
//             'cust_country' => faker()->country(),
//         ];
//     }
// }

use App\Models\Flight;
use Faker\Generator as Faker;
 
$factory->define(Flight::class, function (Faker $faker) {
    return [
        'cust_name' => $faker->sentence(5),
        'cust_email' => $faker->sentence(5),
        'cust_phone' => $faker->sentence(5),
        'cust_address' => $faker->sentence(5),
        'cust_country' => $faker->sentence(5),
    ];
});