<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\KlasifikasiAkun;

class KlasifikasiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\KlasifikasiAkun::factory(10)->create();
    }
}
