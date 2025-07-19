<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'book_title' => $this->faker->sentence(5),
            'book_isbn' => $this->faker->ean13(),
            'book_publication_date' => $this->faker->date(),
            'book_in_stock' => $this->faker->randomDigit(),
            'book_author_id' => $this->faker->numberBetween(1, 20),
            'book_gender_id' => $this->faker->numberBetween(1, 26)
        ];
    }
}
