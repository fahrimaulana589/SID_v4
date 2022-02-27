<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PerangkatDesaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'jabatan' => $this->faker->text(21),
            'persingkat_jabatan' => $this->faker->text(7),
        ];
    }
}
