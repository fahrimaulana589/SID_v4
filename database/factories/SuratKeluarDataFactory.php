<?php

namespace Database\Factories;

use App\Models\SuratKeluar;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuratKeluarDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $data = collect(SuratKeluar::all('id')->toArray())->flatten()->toArray();

        return [
            'id_surat_keluar' => $this->faker->randomElement($data),
            'title' => $this->faker->text(12),
            'description' => $this->faker->text(12),
        ];
    }
}
