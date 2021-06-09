<?php

// use App\Requerimiento;
use Illuminate\Database\Seeder;

class RequerimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		// $users = factory(App\Requerimiento::class, 50)->create();
             factory(\App\Requerimiento::class)->times(100)->create();
        
    }
}
