<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PhoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'phone_type' => $this->faker->name(),
            'phone_number'=> $this->faker->phoneNumber(),
            'updated_at'=>now(),
            'created_at'=>now()
        ];
    }
}
