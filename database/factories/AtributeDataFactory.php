<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AtributeDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'test',
            'key' => 'test',
            'type' => 'test',
        ];
    }
}
