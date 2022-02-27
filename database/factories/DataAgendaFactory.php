<?php

namespace Database\Factories;

use App\Models\Agenda;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataAgendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_agenda' => $this->faker->randomElement(collect(Agenda::all('id')->toArray())->flatten()->toArray()),
            'name' => $this->faker->name(),
            'place_of_birth' => $this->faker->city(),
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['pria','wanita']),
            'profession' => $this->faker->randomElement(['tukang','dokter']),
            'address' => $this->faker->address(),
            'religion' => $this->faker->randomElement(['islam','katolik']),
            'education' => $this->faker->randomElement(['sd','smp']),
            'status' => $this->faker->randomElement(['menikah','belum menikah']),
            'necessity' => 'tugas'
        ];

    }
}
