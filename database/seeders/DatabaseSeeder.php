<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\KlasifikasiAkunFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\KlasifikasiAkun::factory(1000)->create();
    }
}
