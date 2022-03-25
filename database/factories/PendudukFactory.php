<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PendudukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'NIK' => $this->faker->numerify('################'),
            'name' => $this->faker->name(),
            'place_of_birth' => $this->faker->city(),
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['pria','wanita']),
            'blood' => $this->faker->randomElement(['A','B','O','AB']),
            'address' => $this->faker->address(),
            'rt' => $this->faker->numerify('#'),
            'rw' => $this->faker->numerify('#'),
            'kelurahan_desa' => $this->faker->city(),
            'kecamatan' => $this->faker->city(),
            'religion' => $this->faker->randomElement(['islam','khatolik']),
            'status_perkawinan' => $this->faker->randomElement(['menikah','belum menikah']),
            'profession' => 'petugas',
            'kewerganegaraan' => 'WNI',
            'education' => 'SMA',
        ];
    }
}
