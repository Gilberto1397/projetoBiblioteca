<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_name' => $this->faker->name(),
            'user_cpf' => $this->faker->cpf(false),
            //'user_email' => $this->faker->unique()->safeEmail(),
            'user_email' => 'mail@mail.com',
            'user_email_verified_at' => now(),
            'user_password' => '$argon2id$v=19$m=65536,t=4,p=1$RGM1c2RxcVB4WDdzd3Nsdw$Px1DcPSKGcFMZ6sxCMQ7faTkJAKOYoN/7wM0bnHQLFI', // 123456
            'user_telephone' => $this->faker->cellphone(false, true),
            'user_date_birth' => $this->faker->date(),
            'user_register_last_update' => $this->faker->dateTimeBetween('+1 day', '+1 day'),
            'user_userole_id' => $this->faker->numberBetween(1, 2),
            'user_register_active' => $this->faker->boolean(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
