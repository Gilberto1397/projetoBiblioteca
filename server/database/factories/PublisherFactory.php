<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PublisherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'publisher_name' => $this->faker->company(),
            'publisher_country_origin' => $this->faker->country(),
        ];
    }
}
