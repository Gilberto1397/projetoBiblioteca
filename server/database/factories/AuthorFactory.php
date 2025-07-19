<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_name' => $this->faker->name(),
            'author_nationality' => $this->faker->country,
            'author_date_birth' => $this->faker->date()
        ];
    }
}
