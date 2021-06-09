<?php

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
        $this->call(UserSeeder::class);
        $this->call(MedidasSeeder::class);
        $this->call(SectorSeeder::class);
        // $this->call(RequerimientoSeeder::class);
    }
}
