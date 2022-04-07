<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class KlasifikasiAkunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
           
                'no_akun_induk'    => $this->faker->name(),
                'nama_akun_induk'    => $this->faker->name(),
                'sub_akun_induk'    => $this->faker->name(),
                'sub_akun_transaksi' => $this->faker->name(),
       
        ];
    }
}
