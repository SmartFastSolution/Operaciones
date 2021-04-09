<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           app()[PermissionRegistrar::class]->forgetCachedPermissions();

     
        $role1 = Role::create(['name' => 'coordinador']);
      
        $role2 = Role::create(['name' => 'admin']);
       
        $role3 = Role::create(['name' => 'super-admin']);

        $role4 = Role::create(['name' => 'operador']);
        
        DB::table('users')->insert([
         
             'cedula'          => '12345678',
             'username'         =>'administrador',
             'nombres'         =>'Administrador',
             'domicilio'       => 'Guayaqyil',
             'telefono'        => '098765432',
             'celular'         => '049876543',
             'email'           => 'admin@operador.com',
             'password'        => Hash::make('12345678'),
             'estado'          => 'on',
             'created_at'      => now(),
             'updated_at'      => now()
             ]);

            $user = User::find(1);
            $user->assignRole($role3);

    }
}
