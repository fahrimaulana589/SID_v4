<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\DataAgenda;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Agenda::factory(12)->create();
        DataAgenda::factory(12)->create();
    }
}
