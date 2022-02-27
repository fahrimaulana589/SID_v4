<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SuratFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'description'=> $this->faker->text(50),
            'pengirim' => $this->faker->name(),
            'file' => 'xample.jpg',
        ];
    }
}
