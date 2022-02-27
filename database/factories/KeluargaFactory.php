<?php

namespace Database\Factories;

use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeluargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $data =  collect(Penduduk::all('id')->toArray())->flatten()->toArray();

        return [
            'KK' => $this->faker->numerify('###########'),
            'id_kepala_keluarga' => $this->faker->randomElement($data),
            'address' => $this->faker->address(),
            'rt' => $this->faker->numerify('##'),
            'rw' => $this->faker->numerify('##'),
            'kode_pos' => $this->faker->postcode(),
            'kelurahan_desa' => $this->faker->city(),
            'kecamatan' => $this->faker->city(),
            'kabupaten_kota' => $this->faker->city(),
            'provinsi' => $this->faker->state(),
        ];
    }
}
