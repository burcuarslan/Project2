<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;


class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->paragraph(1),
            'address' => $this->faker->address(),
            'district'=> $this->faker->country(),
            'city'=> $this->faker->country(),
            'postal_code'=>$this->faker->numerify,
            'updated_at'=>now(),
            'created_at'=>now()

        ];
    }
}
